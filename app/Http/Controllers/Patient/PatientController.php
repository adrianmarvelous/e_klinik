<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rules\SafeInput;
use App\Models\User;
use App\Models\Roles\Patient;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profile.patient.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', new SafeInput()],
            'dateofbirth' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:255', new SafeInput()],
            'phone' => ['required', 'string', 'max:255', new SafeInput()],
            'address' => ['required', 'string', 'max:255', new SafeInput()],

            // 📁 Files
            'file_1' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_2' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        try {
            DB::transaction(function () use ($validated, $request) {
                // 1️⃣ Update user
                $user = User::findOrFail(session('user.id'));
                $user->update([
                    'name' => $validated['name'],
                ]);

                // 2️⃣ Get or create patient
                $patient = Patient::updateOrCreate(
                    ['user_id' => session('user.id')],
                    [
                        'date_of_birth' => $validated['dateofbirth'],
                        'gender' => $validated['gender'],
                        'phone' => $validated['phone'],
                        'address' => $validated['address'],
                    ],
                );

                // 3️⃣ Handle File 1
                if ($request->hasFile('file_1')) {
                    $file = $request->file('file_1');
                    $filename = time() . '_1_' . $file->getClientOriginalName();
                    $file->storeAs('patients', $filename, 'public');
                    $patient->file_1 = $filename;
                }

                // 4️⃣ Handle File 2
                if ($request->hasFile('file_2')) {
                    $file = $request->file('file_2');
                    $filename = time() . '_2_' . $file->getClientOriginalName();
                    $file->storeAs('patients', $filename, 'public');
                    $patient->file_2 = $filename;
                }

                $patient->save();
            });

            // Update session name
            $userSession = session('user');
            $userSession['name'] = $validated['name'];
            session()->put('user', $userSession);

            return redirect()->route('dashboard')->with('success', 'Patient data updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update patient: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::where('user_id', session('user.id'))->firstOrFail();

        return view('profile.patient.create', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', new SafeInput()],
            'dateofbirth' => ['required', 'date', new SafeInput()],
            'gender' => ['required', 'string', 'max:255', new SafeInput()],
            'phone' => ['required', 'string', 'max:255', new SafeInput()],
            'address' => ['required', 'string', 'max:255', new SafeInput()],
        ]);

        try {
            DB::transaction(function () use ($validated, $patient) {
                // 1. Update nama di tabel users
                $user = User::findOrFail(session('user.id'));
                $user->update([
                    'name' => $validated['name'],
                ]);

                // 2. Update patient
                $patient->update([
                    'date_of_birth' => $validated['dateofbirth'],
                    'gender' => $validated['gender'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                ]);
            });

            // Update session user name
            $userSession = session('user');
            $userSession['name'] = $validated['name'];
            session()->put('user', $userSession);

            return redirect()->route('dashboard')->with('success', 'Patient data updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Failed to update patient: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

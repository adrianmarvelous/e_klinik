<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use App\Models\Roles\Patient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Rules\SafeInput;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all users
        $users = User::all();
        $roles = Roles::all();

        // Pass to the view
        return view('users.index', compact('users', 'roles'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        // Remove old roles and assign new one
        $user->syncRoles([$request->role]);

        return back()->with('success', 'Role updated successfully!');
    }
    public function create_patient()
    {
        return view('users.create_patient');
    }
    public function store_patient(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', new SafeInput()],
            'email' => ['required', 'email', 'max:255'],
            'dateofbirth' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:255', new SafeInput()],
            'phone' => ['required', 'string', 'max:255', new SafeInput()],
            'address' => ['required', 'string', 'max:255', new SafeInput()],

            'file_1' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'file_2' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        try {
            DB::transaction(function () use ($validated, $request) {
                // 1️⃣ Update User
                $user = User::create([
                    'name'     => $validated['name'],
                    'email'    => $validated['email'],
                    'password' => Hash::make('password'),
                ]);
                $user->roles()->attach(3);   // patient role

                // 2️⃣ Create Patient
                $patient = Patient::create([
                    'user_id' => $user->id,
                    'date_of_birth' => $validated['dateofbirth'],
                    'gender' => $validated['gender'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                ]);

                // 3️⃣ Handle file upload
                $this->savePatientFiles($request, $patient);
            });

            return redirect()->route('users.index')->with('success', 'Profil pasien berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function update_patient(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', new SafeInput()],
            'email' => ['required', 'email', 'max:255'],
            'dateofbirth' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:255', new SafeInput()],
            'phone' => ['required', 'string', 'max:255', new SafeInput()],
            'address' => ['required', 'string', 'max:255', new SafeInput()],

            'file_1' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'file_2' => ['nullable', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ]);

        try {
            DB::transaction(function () use ($validated, $request, $patient) {
                // 1️⃣ Update user
                $patient->user->update([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                ]);

                // 2️⃣ Update patient
                $patient->update([
                    'date_of_birth' => $validated['dateofbirth'],
                    'gender' => $validated['gender'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'],
                ]);

                // 3️⃣ Handle file replacement
                $this->savePatientFiles($request, $patient);
            });

            return redirect()->route('dashboard')->with('success', 'Profil pasien berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update data: ' . $e->getMessage());
        }
    }
    private function savePatientFiles(Request $request, Patient $patient)
    {
        if ($request->hasFile('file_1')) {
            if ($patient->file_1 && Storage::disk('public')->exists('patients/' . $patient->file_1)) {
                Storage::disk('public')->delete('patients/' . $patient->file_1);
            }

            $file = $request->file('file_1');
            $name = time() . '_1_' . $file->getClientOriginalName();
            $file->storeAs('patients', $name, 'public');
            $patient->file_1 = $name;
        }

        if ($request->hasFile('file_2')) {
            if ($patient->file_2 && Storage::disk('public')->exists('patients/' . $patient->file_2)) {
                Storage::disk('public')->delete('patients/' . $patient->file_2);
            }

            $file = $request->file('file_2');
            $name = time() . '_2_' . $file->getClientOriginalName();
            $file->storeAs('patients', $name, 'public');
            $patient->file_2 = $name;
        }

        $patient->save();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

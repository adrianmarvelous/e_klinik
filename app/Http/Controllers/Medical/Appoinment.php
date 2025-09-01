<?php

namespace App\Http\Controllers\Medical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rules\SafeInput;
use App\Models\Medical\MedicalHistory;
use App\Models\Roles\Patient;
use App\Models\User;

class Appoinment extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = MedicalHistory::with('patient.user')->get();
        
        return view('appoinment.index',compact('users'));
    }
    public function schedule()
    {
        $doctors = User::role('doctor')->get();

        return view('appoinment.schedule',compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appoinment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'keluhan'  => ['required', 'string', 'max:255', new SafeInput],
        ]);
        try {
            DB::transaction(function () use ($validated) {
                $patient = Patient::where('user_id', session('user.id'))->firstOrFail();

                $medicalHistory = MedicalHistory::updateOrCreate(
                    [
                        'patient_id' => $patient->id, // valid FK
                        'type'       => 'keluhan',
                    ],
                    [
                        'description' => $validated['keluhan'],
                    ]
                );

            });

            return redirect()
                ->route('dashboard')
                ->with('success', 'Medical Report data updated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update patient: ' . $e->getMessage());
        }
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

<?php

namespace App\Http\Controllers\Medical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rules\SafeInput;
use App\Models\Medical\MedicalHistory;
use App\Models\Roles\Patient;
use App\Models\User;
use App\Models\Appoinment\Appoinments;

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
    public function schedule($patient_id)
    {
        $doctors = User::role('doctor')->get();

        return view('appoinment.schedule',compact('doctors','patient_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appoinment.create');
    }
    public function save_schedule(Request $request)
    {
        $validated = $request->validate([
            'patient_id'  => ['required', 'numeric', new SafeInput],
            'doctor_id'   => ['required', 'numeric', new SafeInput],
            'date'        => ['required', 'date', new SafeInput],
            'time'        => ['required', 'date_format:H:i', new SafeInput], // e.g. 14:30
        ]);

        DB::beginTransaction();

        try {
            // Merge date + time into datetime
            $dateTime = $validated['date'] . ' ' . $validated['time'];

            $appointment = new Appoinments();
            $appointment->patient_id = $validated['patient_id'];
            $appointment->doctor_id  = $validated['doctor_id'];
            $appointment->datetime  = $dateTime;
            $appointment->save();

            DB::commit();

            return redirect()
                ->route('appoinment.index')
                ->with('success', 'Jadwal berhasil disimpan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // biarkan Laravel handle redirect back dengan error bag
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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

<?php

namespace App\Http\Controllers\Medical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\SafeInput;
use App\Models\Appoinment\Appoinments;
use App\Models\Medical\MedicalRecord;
use Carbon\Carbon;

class Medical extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medical_history_id' => ['required', 'integer', new SafeInput],
            'patient_summary' => ['nullable', 'string', new SafeInput],
            'doctor_summary' => ['nullable', 'string', new SafeInput],
            'medical_records_id' => ['nullable', 'integer'], // optional for update
        ]);

        // Update if medical_records_id exists, otherwise create
        MedicalRecord::updateOrCreate(
            ['id' => $validated['medical_records_id'] ?? null],
            [
                'medical_history_id' => $validated['medical_history_id'],
                'patient_summary' => $validated['patient_summary'],
                'doctor_summary' => $validated['doctor_summary'],
            ]
        );

        return redirect('appoinment')->with('success', 'Data medical record berhasil disimpan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Appoinments::withIdAppointment($id)->first();
        $age = Carbon::parse($data->patient->date_of_birth)->age;
        // dd($data);
        return view('medical.checkup', compact('data', 'age'));
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

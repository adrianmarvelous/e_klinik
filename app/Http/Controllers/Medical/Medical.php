<?php

namespace App\Http\Controllers\Medical;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\SafeInput;
use App\Models\Appoinment\Appoinments;
use App\Models\Medical\MedicalHistory;
use App\Models\Medical\MedicalRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        // dd($request->all());
        $validated = $request->validate([
            'medical_history_id' => ['required', 'integer', new SafeInput],
            'patient_summary' => ['nullable', 'string', new SafeInput],
            'doctor_summary' => ['nullable', 'string', new SafeInput],
            'medical_records_id' => ['nullable', 'integer'], // optional for update
            'poli_id' => ['nullable', 'integer'], // optional for update
            'jadwal_tanggal' => ['nullable', 'array'],
            'jadwal_jam' => ['nullable', 'array'],
        ]);
        
        $medical_history = MedicalHistory::findOrFail($validated['medical_history_id']);

        try {
            
            DB::beginTransaction();
            // Update if medical_records_id exists, otherwise create
            MedicalRecord::updateOrCreate(
                ['id' => $validated['medical_records_id'] ?? null],
                [
                    'medical_history_id' => $validated['medical_history_id'],
                    'patient_summary' => $validated['patient_summary'],
                    'doctor_summary' => $validated['doctor_summary'],
                ]
            );

            if($validated['jadwal_tanggal']){
                for ($i=0; $i < count($validated['jadwal_tanggal']) ; $i++) { 
                    $new_history = MedicalHistory::create([
                        'patient_id'                => $medical_history->patient_id,
                        'type'                      => 'keluhan',
                        'main_complaint'            => $medical_history->main_complaint,
                        'additional_complaint'      => $medical_history->additional_complaint,
                        'illnes_duration'           => $medical_history->illnes_duration,
                        'smoking'                   => $medical_history->smoking,
                        'alcohol_consumption'       => $medical_history->alcohol_consumption,
                        'low_fruit_veggie_intake'   => $medical_history->low_fruit_veggie_intake,
                    ]);
                    Appoinments::create([
                        'medical_history_id'        => $new_history->id,
                        'patient_id'                => $medical_history->patient_id,
                        'datetime' => date('Y-m-d H:i:s', strtotime($validated['jadwal_tanggal'][$i] . ' ' . $validated['jadwal_jam'][$i])),
                        'poli_id'                   => $validated['poli_id']
                    ]);
                }
            }
            
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }

        return redirect('appoinment')->with('success', 'Data medical record berhasil disimpan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Appoinments::withIdAppointment($id)->first();
        $age = Carbon::parse($data->patient->date_of_birth)->age;
        $appointments = Appoinments::get();
        // dd($appointments);
        return view('medical.checkup', compact('data', 'age','appointments'));
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

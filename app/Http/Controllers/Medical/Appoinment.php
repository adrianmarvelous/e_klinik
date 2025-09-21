<?php

namespace App\Http\Controllers\Medical;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rules\SafeInput;
use App\Models\Medical\MedicalHistory;
use App\Models\Roles\Patient;
use App\Models\Roles\Doctor;
use App\Models\User;
use App\Models\Appoinment\Appoinments;

class Appoinment extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(session('user.roles') == 'admin'){
            $users = MedicalHistory::with([
                            'patient.user',   // nested relation
                            'appointments'    // appointments linked to this medical history
                        ])->orderBy('created_at', 'desc')
                        ->get();
        }elseif(session('user.roles') == 'patient'){
            $users = MedicalHistory::with([
                'patient.user',   // nested relation
                'appointments'
            ])
            ->whereHas('patient.user', function ($query) {
                $query->where('id', session('user.id'));
            })
            ->orderBy('created_at', 'desc')
            ->get();
        }elseif(session('user.roles') == 'doctor'){
            echo $doctorId = session('user.id');
            $users = MedicalHistory::with([
                'patient.user',     // nested relation
                'appointments.doctor.user' // eager load doctor inside appointments
            ])
            ->whereHas('appointments.doctor.user', function ($query) use ($doctorId) {
                $query->where('id', $doctorId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        }
        
                    // dd($users);
        return view('appoinment.index',compact('users'));
    }
    public function schedule($patient_id,$medical_history_id)
    {
        $doctors = User::role('doctor')
                    ->with(['doctor.appointments.doctor' => function ($q) use ($patient_id) {
                        $q->where('patient_id', $patient_id)
                        ->whereBetween('datetime', [
                            Carbon::today(),
                            Carbon::today()->addDays(7)->endOfDay()
                        ]);
                    }])
                    ->get();
        $appointment = Appoinments::where('medical_history_id',$medical_history_id)
                                    ->where('patient_id',$patient_id)
                                    ->first();
        if($appointment){
            $appointment_id = $appointment->id;
        }
        $data = compact('doctors', 'patient_id', 'medical_history_id');

        if ($appointment) {
            $data['appointment_id'] = $appointment_id;
        }

        return view('appoinment.schedule', $data);
    }
    public function sendBookingToPatient($patient_id, $medical_history_id)
    {
        $patient = Patient::with([
            'user',
            'medicalHistories' => function ($query) use ($medical_history_id) {
                $query->where('id', $medical_history_id)
                    ->with('appointments.doctor.user');
            }
        ])
        ->where('id', $patient_id)
        ->firstOrFail();

        $history = $patient->medicalHistories->first();

        $data_pasien = [
            'name'          => $patient->user->name,
            'alamat'        => $patient->address,
            'tanggal_lahir' => date('d-M-Y', strtotime($patient->date_of_birth)),
            'usia'          => Carbon::parse($patient->date_of_birth)->age,
            'email'         => $patient->user->email,
            'keluhan'       => $history->description,
            'jadwal_dokter' => Carbon::parse($history->appointments->datetime)
                                    ->locale('id')
                                    ->translatedFormat('d F Y H:i'),
            'doctor'        => $history->appointments->doctor->user->name,
        ];

        // Build pesan
        $message = "Halo Selamat Siang,\n\n"
            . "Kami dari Klinik .... menginformasikan.\n\n"
            . "- Nama Pasien : {$data_pasien['name']}\n"
            . "- Alamat      : {$data_pasien['alamat']}\n"
            . "- Tanggal Lahir : {$data_pasien['tanggal_lahir']}\n"
            . "- Usia        : {$data_pasien['usia']}\n"
            . "- E-mail      : {$data_pasien['email']}\n"
            . "- Keluhan     : {$data_pasien['keluhan']}\n"
            . "- Dokter      : {$data_pasien['doctor']}\n"
            . "- Jadwal      : {$data_pasien['jadwal_dokter']}\n"
            . "Terima kasih.";

        $encodedMessage = urlencode($message);
        $phone = preg_replace('/[^0-9]/', '', $patient->phone); // sanitize number

        $waLink = "https://wa.me/{$phone}?text={$encodedMessage}";

        // 🔥 Redirect straight to WhatsApp
        return redirect()->away($waLink);
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
            'appointment_id'      => ['nullable', 'numeric', new SafeInput],
            'patient_id'          => ['required', 'numeric', new SafeInput],
            'doctor_id'           => ['required', 'numeric', new SafeInput],
            'medical_history_id'  => ['required', 'numeric', new SafeInput],
            'date'                => ['required', 'date', new SafeInput],
            'time'                => ['required', 'date_format:H:i', new SafeInput], // e.g. 14:30
        ]);

        DB::beginTransaction();

        try {
            // Merge date + time into datetime
            $dateTime = $validated['date'] . ' ' . $validated['time'];

            if (!empty($validated['appointment_id'])) {
                // ✅ Update existing appointment
                $appointment = Appoinments::findOrFail($validated['appointment_id']);
            } else {
                // ✅ Create new appointment
                $appointment = new Appoinments();
            }

            $appointment->medical_history_id = $validated['medical_history_id'];
            $appointment->patient_id = $validated['patient_id'];
            $appointment->doctor_id  = $validated['doctor_id'];
            $appointment->datetime   = $dateTime;
            $appointment->save();

            DB::commit();

            return redirect()
                ->route('appoinment.index')
                ->with('success', 'Jadwal berhasil disimpan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e; // biarkan Laravel handle redirect back dengan error bag
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
            'keluhan' => ['required', 'string', 'max:1000000', new SafeInput],
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $patient = Patient::where('user_id', session('user.id'))->firstOrFail();

                MedicalHistory::create([
                    'patient_id'  => $patient->id,
                    'type'        => 'keluhan',
                    'description' => $validated['keluhan'],
                ]);
            });

            return redirect()
                ->route('dashboard')
                ->with('success', 'Medical Report data created successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create patient medical report: ' . $e->getMessage());
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

<?php

namespace App\Models\Appoinment;

use Illuminate\Database\Eloquent\Model;
use App\Models\Medical\MedicalHistory;
use App\Models\Roles\Doctor;
use App\Models\Roles\Patient;
use App\Models\User;
use App\Models\Medical\Polis;

class Appoinments extends Model
{
    protected $table = 'appointments';
    protected $fillable = [
        'id',
        'medical_history_id',
        'patient_id',
        'poli_id',
        'datetime',
    ];
    
        
    // ✅ Each appointment belongs to one medical history
    public function medicalHistory()
    {
        return $this->belongsTo(MedicalHistory::class, 'medical_history_id', 'id');
    }
    // ✅ Each appointment belongs to one medical history
    public function polis()
    {
        return $this->belongsTo(Polis::class, 'polis_id', 'id');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    // 🔹 Query Scope: filter by attendance date
    public function scopeWithAttendanceDate($query, $date = null)
    {
        $date = $date ?? date('Y-m-d');

        return $query->with(['patient.user'/*, 'doctor.user',*/])
                     ->whereDate('datetime', $date)
                     ->orderBy('datetime', 'desc');
    }
    public function scopeWithIdAppointment($query, $id)
    {
        return $query->with(['patient.user', /*'doctor.user',*/'medicalHistory.medical_records','medicalHistory.doctor'])
                     ->where('medical_history_id', $id);
    }

}

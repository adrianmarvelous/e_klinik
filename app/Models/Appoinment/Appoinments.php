<?php

namespace App\Models\Appoinment;

use Illuminate\Database\Eloquent\Model;
use App\Models\Medical\MedicalHistory;
use App\Models\Roles\Doctor;

class Appoinments extends Model
{
    protected $table = 'appointments';
    protected $fillable = [
        'id',
        'patient_id',
        'doctor_id',
        'datetime',
    ];
    
        
    // ✅ Each appointment belongs to one medical history
    public function medicalHistory()
    {
        return $this->belongsTo(MedicalHistory::class, 'medical_history_id', 'id');
    }
    // ✅ Each appointment belongs to one medical history
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }

}

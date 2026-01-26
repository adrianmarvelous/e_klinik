<?php

namespace App\Models\Medical;

use Illuminate\Database\Eloquent\Model;
use App\Models\Roles\Patient;
use App\Models\Appoinment\Appoinments;
use App\Models\Medical\MedicalRecord;
use App\Models\Roles\Doctor;

class MedicalHistory extends Model
{
    protected $table = 'medical_history';
    protected $fillable = [
        'patient_id',
        'type',
        'description',
        'main_complaint',
        'additional_complaint',
        'illness_duration',
        'smoking',
        'alcohol_consumption',
        'low_fruit_veggie_intake',
    ];
    
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    // ✅ One medical history can be linked to many appointments
    public function appointments()
    {
        return $this->hasOne(Appoinments::class, 'medical_history_id', 'id');
    }
    // ✅ One medical history can be linked to many appointments
    public function medical_records()
    {
        return $this->hasOne(MedicalRecord::class);
    }
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id');
    }
}

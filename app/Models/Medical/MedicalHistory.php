<?php

namespace App\Models\Medical;

use Illuminate\Database\Eloquent\Model;
use App\Models\Roles\Patient;
use App\Models\Appoinment\Appoinments;

class MedicalHistory extends Model
{
    protected $table = 'medical_history';
    protected $fillable = [
        'patient_id',
        'type',
        'description',
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
}

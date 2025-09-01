<?php

namespace App\Models\Medical;

use Illuminate\Database\Eloquent\Model;
use App\Models\Roles\Patient;

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
}

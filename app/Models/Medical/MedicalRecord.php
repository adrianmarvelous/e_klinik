<?php

namespace App\Models\Medical;

use Illuminate\Database\Eloquent\Model;
use App\Models\Medical\MedicalHistory;

class MedicalRecord extends Model
{
    protected $table = 'medical_records';
    protected $fillable = [
        'id',
        'medical_history_id',
        'patient_summary',
        'doctor_summary',
    ];

    public function medical_history()
    {
        return $this->belongsTo(MedicalHistory::class);
    }
}

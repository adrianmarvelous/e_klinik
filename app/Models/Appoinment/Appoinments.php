<?php

namespace App\Models\Appoinment;

use Illuminate\Database\Eloquent\Model;

class Appoinments extends Model
{
    protected $table = 'appointments';
    protected $fillable = [
        'id',
        'patient_id',
        'doctor_id',
        'datetime',
    ];
}

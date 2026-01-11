<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Medical\MedicalHistory;

class Patient extends Model
{
    protected $table = 'patients';
    protected $fillable = [
        'user_id', // Assuming you want to set the ID manually
        'date_of_birth',
        'gender',
        'phone',
        'address',
        'file_1',
        'file_2',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class);
    }
}

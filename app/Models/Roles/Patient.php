<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';
    protected $fillable = [
        'user_id', // Assuming you want to set the ID manually
        'date_of_birth',
        'gender',
        'phone',
        'address',
    ];
}

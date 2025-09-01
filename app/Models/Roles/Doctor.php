<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Doctor extends Model
{
    protected $table = 'doctors';
    protected $fillable = [
        'user_id', // Assuming you want to set the ID manually
        'gender',
        'specialization',
        'phone',
        'address',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

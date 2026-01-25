<?php

namespace App\Models\Roles;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Appoinment\Appoinments;

class Doctor extends Model
{
    protected $table = 'doctors';
    protected $fillable = [
        'user_id', // Assuming you want to set the ID manually
        'name',
        'gender',
        'specialization',
        'bio',
        'phone',
        'address',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appoinments::class,'doctor_id','id');
    }
}

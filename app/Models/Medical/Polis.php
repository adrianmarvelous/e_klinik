<?php

namespace App\Models\Medical;

use Illuminate\Database\Eloquent\Model;
use App\Models\Appoinment\Appoinments;

class Polis extends Model
{
    //
    protected $table = 'polis';
    
    public function appointments()
    {
        return $this->hasMany(Appoinments::class,'polis_id','id');
    }
}

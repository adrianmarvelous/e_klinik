<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appoinment\Appoinments;
use App\Models\Roles\Patient;

class DashboardController extends Controller
{
    public function index()
    {
        $patient = Patient::where('user_id', session('user.id'))->first();
        $appoinment = Appoinments::where('patient_id', $patient->id)
                                    ->where('datetime', '>=', now())
                                    ->get();
                                    
        return view('dashboard',compact('appoinment'));
    }
}

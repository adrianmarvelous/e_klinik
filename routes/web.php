<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Patient\PatientController;
use App\Http\Controllers\Patient\ListPatientController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Medical\Appoinment;
use App\Http\Controllers\Medical\Attendance;
use App\Http\Controllers\Medical\Medical;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);


// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    //
    Route::resource('patient', PatientController::class);
    Route::get('/doctor/admin_create', [DoctorController::class, 'admin_create'])->name('doctor.admin_create');
    Route::post('/doctor/store_doctor', [DoctorController::class, 'store_doctor'])->name('doctor.store_doctor');
    Route::resource('doctor', DoctorController::class);
    Route::get('/appoinment/schedule/cancel/{id}', [Appoinment::class, 'cancel'])->name('appointment.cancel');
    Route::get('/appoinment/schedule/edit/{id}', [Appoinment::class, 'edit'])->name('appointment.edit');
    Route::get('/appoinment/schedule/{patient_id}/{medical_history_id}', [Appoinment::class, 'schedule'])->name('appoinment.schedule');
    Route::get('/appoinment/sendBookingToPatient/{patient_id}/{medical_history_id}', [Appoinment::class, 'sendBookingToPatient'])->name('appoinment.sendBookingToPatient');
    Route::get('/appoinment/sendBookingToDoctor/{patient_id}/{medical_history_id}', [Appoinment::class, 'sendBookingToDoctor'])->name('appoinment.sendBookingToDoctor');
    Route::post('/appoinment/save_schedule', [Appoinment::class, 'save_schedule'])->name('appoinment.save_schedule');
    Route::resource('appoinment', Appoinment::class);

    Route::resource('attendance', Attendance::class);
    Route::resource('medical', Medical::class);

    // ✅ Admin-only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('list_patient', ListPatientController::class);
        Route::resource('users', UserController::class);
        Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::get('/users/patient/create', [UserController::class, 'create_patient'])->name('users.create_patient');
        Route::post('/users/patient/store_patient', [UserController::class, 'store_patient'])->name('users.store_patient');
        Route::post('/users/patient/update_patient', [UserController::class, 'update_patient'])->name('users.update_patient');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

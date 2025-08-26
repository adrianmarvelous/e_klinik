<?php
    return [
        'admin' => [
            ['name' => 'Dashboard', 'route' => 'admin.dashboard','icon' => 'home'],
            ['name' => 'Manage Users', 'route' => 'users.index','icon' => 'users'],
        ],
        'doctor' => [
            ['name' => 'Appointments', 'route' => 'appointments.index','icon' => 'calendar'],
        ],
        'patient' => [
            ['name' => 'Book Appointment', 'route' => 'booking.index'],
        ],
    ];

?>
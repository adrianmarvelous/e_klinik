<?php
    return [
        'admin' => [
            ['name' => 'Manage Users', 'route' => 'users.index','icon' => 'users'],
            ['name' => 'Appoinment', 'route' => 'appoinment.index','icon' => 'calendar'],
        ],
        'doctor' => [
            ['name' => 'Appointments', 'route' => 'appoinment.index','icon' => 'calendar'],
        ],
        'patient' => [
            ['name' => 'Book Appointment', 'route' => 'appoinment.create','icon' => 'hospital'],
            ['name' => 'Medical History', 'route' => 'appoinment.index','icon' => 'history'],
        ],
    ];

?>
<?php
    return [
        'admin' => [
            ['name' => 'Manage Users', 'route' => 'users.index','icon' => 'users'],
            ['name' => 'Appoinment', 'route' => 'appoinment.index','icon' => 'calendar'],
        ],
        'doctor' => [
            ['name' => 'Appointments', 'route' => 'users.index','icon' => 'calendar'],
        ],
        'patient' => [
            ['name' => 'Book Appointment', 'route' => 'booking.index','icon' => 'users'],
        ],
    ];

?>
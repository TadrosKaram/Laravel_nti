<?php

return [

    'defaults' => [
        'guard' => 'web', // Default guard
        'passwords' => 'users',
    ],

    // GUARDS
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'student' => [
            'driver' => 'session',
            'provider' => 'students',
        ],

        'doctor' => [
            'driver' => 'session',
            'provider' => 'doctors',
        ],

    ],

    // PROVIDERS
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'students' => [
            'driver' => 'eloquent',
            'model' => App\Models\Student::class,
        ],

        'doctors' => [
            'driver' => 'eloquent',
            'model' => App\Models\Doctor::class,
        ],

    ],

    // PASSWORD RESET CONFIGS (Optional unless you implement password resets)
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'students' => [
            'provider' => 'students',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],

        'doctors' => [
            'provider' => 'doctors',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],


    ],

    'password_timeout' => 10800,

];

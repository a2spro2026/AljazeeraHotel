<?php

return [

    'admin' => [
        'label'    => 'Direction',
        'login'    => env('SPACE_DIRECTION_LOGIN', 'Direction'),
        'password' => env('SPACE_DIRECTION_PASSWORD', 'password'),
        'route'    => 'admin',
        'manager_logins' => ['Direction'],
    ],

    'facturation' => [
        'label'    => 'Facturation',
        'login'    => env('SPACE_FACTURATION_LOGIN', 'Facturation'),
        'password' => env('SPACE_FACTURATION_PASSWORD', 'password'),
        'route'    => 'facturation',
    ],

    'commercial' => [
        'label'    => 'Commercial',
        'login'    => env('SPACE_COMMERCIAL_LOGIN', 'Commercial'),
        'password' => env('SPACE_COMMERCIAL_PASSWORD', 'password'),
        'route'    => 'commercial',
    ],

];

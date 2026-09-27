<?php

return [

    'admin' => [
        'label'    => 'Direction',
        'login'    => env('SPACE_DIRECTION_LOGIN'),
        'password' => env('SPACE_DIRECTION_PASSWORD'),
        'route'    => 'admin',
        'manager_logins' => array_values(array_filter([env('SPACE_DIRECTION_LOGIN'), 'Direction'])),
    ],

    'facturation' => [
        'label'    => 'Facturation',
        'login'    => env('SPACE_FACTURATION_LOGIN'),
        'password' => env('SPACE_FACTURATION_PASSWORD'),
        'route'    => 'facturation',
    ],

    'commercial' => [
        'label'    => 'Commercial',
        'login'    => env('SPACE_COMMERCIAL_LOGIN'),
        'password' => env('SPACE_COMMERCIAL_PASSWORD'),
        'route'    => 'commercial',
    ],

];

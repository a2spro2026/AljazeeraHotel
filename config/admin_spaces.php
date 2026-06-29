<?php

return [

    'admin' => [
        'label'    => 'Direction',
        'login'    => env('SPACE_DIRECTION_LOGIN', 'direction'),
        'password' => env('SPACE_DIRECTION_PASSWORD', 'Direction@2026'),
        'route'    => 'admin',
    ],

    'facturation' => [
        'label'    => 'Facturation',
        'login'    => env('SPACE_FACTURATION_LOGIN', 'facturation'),
        'password' => env('SPACE_FACTURATION_PASSWORD', 'Facture@2026'),
        'route'    => 'facturation',
    ],

    'commercial' => [
        'label'    => 'Commercial',
        'login'    => env('SPACE_COMMERCIAL_LOGIN', 'commercial'),
        'password' => env('SPACE_COMMERCIAL_PASSWORD', 'Commercial@2026'),
        'route'    => 'commercial',
    ],

];

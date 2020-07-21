<?php

use PurpleHexagon\Actions\GetVegetablesAction;

// TODO merge in local config so db creds etc can be overridden
return [
    'db' => [
        'database_type' => 'pgsql',
        'database_name' => 'postgres',
        'server' => 'db',
        'username' => 'postgres',
    ],
    'routes' => [
        'default' => [
            'method' => 'GET',
            'route' => '/vegetables',
            'handler' => GetVegetablesAction::class,
        ]
    ]
];

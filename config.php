<?php

use App\Models\User;
use PXP\Auth\Models\Identity;

return [
    'title' => 'Family Tree',

    'domain' => env('HOST', 'localhost'),
    'port' => env('PORT', 8085),

    'css' => [
        'media',
        'colors',
        'base',
        'snippets',
        'button',
        'table',
        'notification',
        'components',
        'form',
    ],

    'modules' => [
        'auth' => 'leonickl/pxp-auth',
    ],

    'resolver' => [
        Identity::class => User::class,
    ],

    'auth' => [
        'roles' => [
            'levels' => [
                'VISITOR' => 0,
                'EDITOR' => 1,
                'ADMIN' => 2,
            ],

            'labels' => [
                'VISITOR' => 'Besucher:in',
                'EDITOR' => 'Bearbeiter:in',
                'ADMIN' => 'Admin',
            ],
        ],
    ],
];

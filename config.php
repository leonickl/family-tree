<?php

use App\Models\User;
use PXP\Auth\Models\Identity;

return [
    'title' => 'Family Tree',

    'app-url' => env('APP_URL', 'http://localhost:8085'),
    'port' => env('PORT', 8085),

    'mail' => (object) [
        'host' => env('MAIL_HOST'),
        'user' => env('MAIL_USER'),
        'pass' => env('MAIL_PASS'),
        'port' => env('MAIL_PORT'),
    ],

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

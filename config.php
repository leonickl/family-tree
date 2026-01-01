<?php

return [
    'title' => 'Family Tree',
    'domain' => env('HOST', 'localhost'),
    'port' => env('PORT', 8085),
    'users' => json_decode(env('USERS')),
];

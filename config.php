<?php

return [
    'title' => 'Family Tree',
    'domain' => 'localhost',
    'port' => 8085,
    'users' => json_decode(env('USERS')),
];

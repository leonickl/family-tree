<?php

require __DIR__.'/vendor/autoload.php';

$db = \PXP\Core\Lib\DB::init();

$db->create('people', [
    'name' => 'text not null',
    'email' => 'text not null',
]);

$db->create('users', [
    'username' => 'text unique not null',
    'password_hash' => 'text not null',
]);

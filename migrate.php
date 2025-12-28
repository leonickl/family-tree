<?php

require __DIR__.'/vendor/autoload.php';

$db = \PXP\Core\Lib\DB::init();

$db->create('people', [
    'name' => 'text not null',
    'email' => 'text not null',
]);

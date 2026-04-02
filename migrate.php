<?php

require __DIR__.'/vendor/autoload.php';

$db = \PXP\Data\DB::init();

$db->create('people', [
    'name_prefix' => 'text',
    'name_first' => 'text',
    'name_last' => 'text',
    'name_marriage' => 'text',
    'name_suffix' => 'text',
    'gender' => 'text',
    'birth_date' => 'text',
    'birth_place' => 'text',
    'death' => 'text',
    'death_date' => 'text',
    'death_place' => 'text',
    'death_cause' => 'text',
    'buriage_date' => 'text',
    'buriage_place' => 'text',
]);

$db->create('families', [
    'husband_id' => 'int references people(id)',
    'wife_id' => 'int references people(id)',
]);

$db->create('child_relations', [
    'child_id' => 'int not null references people(id)',
    'family_id' => 'int not null references families(id)',
]);

$db->create('users', [
    'username' => 'text not null',
    'password_hash' => 'text not null',
    'person_id' => 'int',
]);

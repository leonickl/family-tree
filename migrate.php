<?php

use PXP\Data\DB;

require __DIR__.'/vendor/autoload.php';

$db = DB::init();

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
    'email' => 'text not null',
    'password_hash' => 'text not null',
    'role' => 'int not null default 0',
    'name' => "string not null default ''",
    'verified' => 'int not null default 0',
    'person_id' => 'int',
]);

$db->sql('create unique index if not exists '.
    'unique_users_email on users(email)');

$db->sql('create unique index if not exists '.
    'unique_users_person_id on users(person_id)');

$db->create('verification_link', [
    'token' => 'string not null',
    'user_id' => 'int references user(id)',
]);

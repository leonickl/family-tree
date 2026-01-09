<?php

require __DIR__.'/vendor/autoload.php';

$db = \PXP\Core\Lib\DB::init();

$db->create('people', [
    'identifier' => 'text not null unique',
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
    'identifier' => 'text not null unique',
    'husband_identifier' => 'text references people(identifier)',
    'wife_identifier' => 'text references people(identifier)',
]);

$db->create('child_relations', [
    'child_identifier' => 'text not null references people(identifier)',
    'family_identifier' => 'text not null references families(identifier)',
]);


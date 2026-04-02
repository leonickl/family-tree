<?php

use App\Models\User;
use PXP\Console\Command;

/**
 * Add a postfix to all ids. Useful when you want to merge
 * multiple gedcom files.
 */
Command::new('postfix-ids', function (?string $file = null, ?string $postfix = null) {
    if ($file === null) {
        exit("Please enter a tree's name\n");
    }

    if ($postfix === null) {
        exit("Please enter a postfix\n");
    }

    $tree = file_get_contents(path("database/$file.ged"));

    preg_match_all('/@([A-Za-z][A-Za-z0-9_-]*)@/', $tree, $matches);

    $identifiers = array_values(array_unique($matches[0]));

    $new = [];

    foreach ($identifiers as $identifier) {
        if (! array_key_exists($identifier[1], $new)) {
            $new[$identifier[1]] = [];
        }

        $new[$identifier[1]][$identifier] = '@'.$identifier[1].(count($new[$identifier[1]]) + 1).$postfix.'@';
    }

    echo json_encode($new, JSON_PRETTY_PRINT), "\n";

    foreach ($new as $category) {
        foreach ($category as $old => $new) {
            $tree = str_replace($old, $new, $tree);
        }
    }

    file_put_contents(path("database/$file.ged"), $tree);

    exit("\nnew tree written\n");
});

/**
 * The final gedcom file must have numeric ids for theimport.
 * This function converts to the correct format.
 */
Command::new('numerify-ids', function (?string $file = null) {
    if ($file === null) {
        exit("Please enter a tree's name\n");
    }

    $tree = file_get_contents(path("database/$file.ged"));

    preg_match_all('/@([A-Za-z][A-Za-z0-9_-]*)@/', $tree, $matches);

    $identifiers = array_values(array_unique($matches[1]));

    $counters = [];
    $new_ids = [];

    foreach ($identifiers as $identifier) {
        $prefix = $identifier[0];

        if(! array_key_exists($prefix, $counters)) {
            $counters[$prefix] = 1;
        }

        $new_id = $counters[$prefix]++;

        if(! array_key_exists($identifier, $new_ids)) {
            $new_ids[$identifier] = $new_id;
        }
    }

    foreach ($new_ids as $old => $new) {
        $tree = str_replace("@$old@", "@$new@", $tree);
    }

    file_put_contents(path("database/$file.ged"), $tree);

    exit("ids numerified\n");
});

/**
 * This command converts the final gedcom file to a json-based
 * format used for import.
 */
Command::new('to-json', function (?string $file = null) {
    if ($file === null) {
        exit("Please enter a tree's name\n");
    }

    $object = App\Converter::read(path("database/$file.ged"))
        ->convert()
        ->simplify()
        ->get();

    file_put_contents(
        path("database/$file.json"),
        json_encode($object, JSON_PRETTY_PRINT),
    );

    exit("converted gedcom to json\n");
});

/**
 * Import the generated json file.
 */
Command::new('import', function (?string $file = null) {
    if ($file === null) {
        exit("Please enter a tree's name\n");
    }

    $importer = new \App\Importer($file);

    $importer->people();
    $importer->families();

    exit("tree imported\n");
});


Command::new('create-user', function (?string $username = null, ?string $password = null, ?int $person_id = null) {
    if ($username === null) {
        exit("Please enter a username\n");
    }

    if ($password === null) {
        exit("Please enter a password\n");
    }

    if ($person_id === null) {
        exit("Please enter a person id\n");
    }

    $user = User::create(
        username: $username,
        password_hash: password_hash($password, PASSWORD_DEFAULT),
        person_id: $person_id,
    );

    exit("created user with id $user->id\n");
});

Command::new('change-password', function (?string $username = null, ?string $password = null) {
    if ($username === null) {
        exit("Please enter a username\n");
    }

    if ($password === null) {
        exit("Please enter a password\n");
    }

    $user = User::findByOrNull('username', $username);

    if ($user === null) {
        exit("User not found\n");
    }

    $user->setPasswordHash($password);
    $user->save();

    exit("Changed password for $user->username\n");
});
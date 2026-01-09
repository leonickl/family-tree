<?php

use PXP\Core\Lib\Command;

use App\Tree;
use App\Types\Person;
use App\Types\Family;
use App\Models\User;

Command::new('reidentify', function (?string $file = null, ?string $postfix = null) {
    if ($file === null) {
        exit("Please enter a tree's name\n");
    }

    if ($postfix === null) {
        exit("Please enter a postfix\n");
    }

    $tree = file_get_contents(path("database/trees/$file.ged"));

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

    file_put_contents(path("database/trees/$file.ged"), $tree);

    echo "\nnew tree written\n";
});

Command::new('check', function(?string $file = null) {
    if ($file === null) {
        exit("Please enter a tree's name\n");
    }

    $tree = Tree::init($file);

    foreach(Person::all() as $i => $person) {
        $childFamiliesForward = $person->childFamilies()
            ->map(fn(Family $family) => $family->id())->toArray();
        $childFamiliesBackward = Family::all()->filter(function (Family $family) use ($person) {
            foreach ($family->children() as $child) {
                if ($child->id() === $person->id()) {
                    return true;
                }
            }

            return false;
        })
            ->map(fn(Family $family) => $family->id())->toArray();
        
        $spousalFamiliesForward = $person->spousalFamilies()
            ->map(fn(Family $family) => $family->id())->toArray();
        $spousalFamiliesBackward = Family::all()->filter(function (Family $family) use ($person) {
            if ($family->husband()?->id() === $person->id()) {
                return true;
            }

            if ($family->wife()?->id() === $person->id()) {
                return true;
            }

            return false;
        })
            ->map(fn(Family $family) => $family->id())->toArray();

        sort($childFamiliesForward);
        sort($childFamiliesBackward);

        sort($spousalFamiliesForward);
        sort($spousalFamiliesBackward);

        if($childFamiliesForward != $childFamiliesBackward) {
            echo $person->id(), ' - child: ', json_encode($childFamiliesForward), json_encode($childFamiliesBackward), "\n\n";
        }

        if($spousalFamiliesForward != $spousalFamiliesBackward) {
            echo $person->id(), ' - spousal: ', json_encode($spousalFamiliesForward), json_encode($spousalFamiliesBackward), "\n\n";
        }
    }
});

Command::new('convert', function(?string $file = null) {
    if ($file === null) {
        exit("Please enter a tree's name\n");
    }

    $object = App\Converter::read(path("database/trees/$file.ged"))
        ->convert()
        ->simplify()
        ->get();

    file_put_contents(
        path("database/trees/$file.json"), 
        json_encode($object, JSON_PRETTY_PRINT),
    );

    echo "converted gedcom to json\n";
});

Command::new('create-user', function(?string $username, ?string $password) {
    if ($username === null) {
        exit("Please enter a username\n");
    }

    if ($password === null) {
        exit("Please enter a password\n");
    }

    $user = User::create(username: $username, password_hash: password_hash($password, PASSWORD_DEFAULT));

    echo "created user with id $user->id\n";
});

Command::new('import', function(?string $file = null) {
    if ($file === null) {
        exit("Please enter a tree's name\n");
    }

    $importer = new \App\Importer($file);

    $importer->people();
    $importer->families();
});

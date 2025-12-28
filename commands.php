<?php

use PXP\Core\Lib\Command;

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

<?php

namespace App;

use App\Types\Person;

class Link
{
    public function tree(?Person $person)
    {
        if($person === null) {
            return '---';
        }

        $tree = Tree::make();
        $id = $person->id();

        return "<a href=\"/tree/$tree->file?start=$id\">$person</a>";
    }
}

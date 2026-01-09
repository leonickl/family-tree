<?php

namespace App;

use App\Models\Person;

class Link
{
    public function tree(?Person $person)
    {
        if ($person === null) {
            return '---';
        }

        $id = $person->id();

        return "<a href=\"/tree?start=$id\">$person</a>";
    }
}

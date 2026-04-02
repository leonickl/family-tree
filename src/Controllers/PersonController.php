<?php

namespace App\Controllers;

use App\Models\Person;
use PXP\Http\Controllers\Controller;

class PersonController extends Controller
{
    public function show(string $id)
    {
        $person = Person::findByOrNull('identifier', $id);

        if ($person === null) {
            throw new Exception("Person with id '$id' not found");
        }

        return view('person', compact('person'));
    }
}

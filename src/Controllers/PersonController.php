<?php

namespace App\Controllers;

use PXP\Lib\Auth;
use PXP\Http\Controllers\Controller;
use PXP\Exceptions\ValidationException;
use PXP\Router\Router;
use App\Models\Person;

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

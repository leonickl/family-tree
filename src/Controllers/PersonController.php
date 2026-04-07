<?php

namespace App\Controllers;

use App\Models\Person;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;

class PersonController extends Controller
{
    public function show(int $id)
    {
        return view('person', [
            'person' => Person::find($id),
        ]);
    }

    public function edit(int $id)
    {
        return view('person.edit', [
            'person' => Person::find($id),
        ]);
    }

    public function update(int $id)
    {
        $request = request([
            'name_prefix',
            'name_first',
            'name_last',
            'name_marriage',
            'name_suffix',
            'gender',
            'birth_date',
            'birth_place',
            'death',
            'death_date',
            'death_place',
            'death_cause',
            'buriage_date',
            'buriage_place',
        ]);

        $person = Person::find($id)
            ->fill(...$request)
            ->save();

        return Redirect::path("/people/$person->id");
    }
}

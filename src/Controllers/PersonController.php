<?php

namespace App\Controllers;

use App\Models\Person;
use PXP\Auth\Auth;
use PXP\Auth\Role;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Http\Response\Response;

class PersonController extends Controller
{
    public function show(int $id): Response
    {
        return view('person', [
            'person' => Person::find($id),
            'canWrite' => Auth::user()?->role()->atLeast(Role::EDITOR()) ?? false,
        ]);
    }

    public function edit(int $id): Response
    {
        return view('person.edit', [
            'person' => Person::find($id),
        ]);
    }

    public function update(int $id): Response
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

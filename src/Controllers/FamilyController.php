<?php

namespace App\Controllers;

use App\Models\Family;
use App\Models\Person;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;

class FamilyController extends Controller
{
    public function index()
    {
        return view('families', [
            'families' => Family::all(),
        ]);
    }

    public function show(int $id)
    {
        return view('family', [
            'family' => Family::find($id),
        ]);
    }

    public function addParent(int $id)
    {
        Family::find($id)
            ->addParent($parent = Person::create());

        return Redirect::path("/people/$parent->id/edit");
    }

    public function addChild(int $id)
    {
        Family::find($id)
            ->addChild($child = Person::create());

        return Redirect::path("/people/$child->id/edit");
    }

    public function createChild()
    {
        $person = Person::find((int) request('person_id'));

        Family::create()
            ->addChild($person);

        return Redirect::path("/people/$person->id");
    }

    public function createSpousal()
    {
        $person = Person::find((int) request('person_id'));

        Family::create()
            ->addParent($person);

        return Redirect::path("/people/$person->id");
    }
}

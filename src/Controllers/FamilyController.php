<?php

namespace App\Controllers;

use App\Models\Family;
use App\Models\Person;
use PXP\Http\Controllers\Controller;
use PXP\Router\Router;

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
        $family = Family::find($id);

        $parent = Person::create();

        $family->addParent($parent);

        Router::redirect("/people/$parent->id/edit");
    }

    public function addChild(int $id)
    {
        $family = Family::find($id);

        $child = Person::create();

        $family->addChild($child);

        Router::redirect("/people/$child->id/edit");
    }

    public function createChild()
    {
        $person = Person::find((int)request('person_id'));

        Family::create()
            ->addParent($person);

        Router::redirect("/people/$person->id");
    }

    public function createSpousal()
    {
        $person = Person::find((int)request('person_id'));

        Family::create()
            ->addChild($person);

        Router::redirect("/people/$person->id");
    }
}

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

    public function addParent(string $id)
    {
        $family = Family::find($id);

        $parent = Person::create();

        $family->addParent($parent);

        Router::redirect("/tree/people/$parent->id/edit");
    }

    public function addChild(string $id)
    {
        $family = Family::find($id);

        $child = Person::create();

        $family->addChild($child);

        Router::redirect("/tree/people/$child->id/edit");
    }
}

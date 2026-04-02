<?php

namespace App\Controllers;

use App\Models\Family;
use PXP\Http\Controllers\Controller;

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
        $family = Family::findOrNull($id);

        if ($family === null) {
            throw new Exception("Family with id '$id' not found");
        }

        return view('family', compact('family'));
    }

    public function addParent(string $id) {}

    public function addChild(string $id) {}
}

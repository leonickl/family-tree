<?php

namespace App\Http\Controllers;

class FamilyController extends Controller
{
    public function index()
    {
        return inertia('Families', [
            'families' => tree()->families()->values()->toArray(),
        ]);
    }

    public function show(string $id)
    {
        return inertia('Family', [
            'family' => tree()->family($id)?->toArray(),
        ]);
    }
}

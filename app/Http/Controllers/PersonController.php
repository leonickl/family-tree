<?php

namespace App\Http\Controllers;

class PersonController extends Controller
{
    public function index()
    {
        return inertia('People', [
            'people' => tree()->people()->values()->toArray(),
        ]);
    }

    public function show(string $id)
    {
        return inertia('Person', [
            'person' => tree()->person($id)?->toArray(),
        ]);
    }
}

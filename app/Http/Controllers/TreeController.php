<?php

namespace App\Http\Controllers;

class TreeController extends Controller
{
    public function index()
    {
        return inertia('Tree', [
            'families' => tree()->families()->toArray(),
        ]);
    }
}

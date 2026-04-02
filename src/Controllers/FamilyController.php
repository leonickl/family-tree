<?php

namespace App\Controllers;

use PXP\Lib\Auth;
use PXP\Http\Controllers\Controller;
use PXP\Exceptions\ValidationException;
use PXP\Router\Router;
use App\Models\Family;

class FamilyController extends Controller
{
    public function index()
    {
        return view('families', [
            'families' => Family::all(),
        ]);
    }

    public function show(string $id)
    {
        $family = Family::findByOrNull('identifier', $id);

        if ($family === null) {
            throw new Exception("Family with id '$id' not found");
        }

        return view('family', compact('family'));
    }
}

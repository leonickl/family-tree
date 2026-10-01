<?php

namespace App\Controllers;

use App\Models\Family;
use App\Models\Person;
use App\Plot\Plot;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Response;
use PXP\Auth\Auth;

class TreeController extends Controller
{
    public function tree(): Response
    {
        if (request('start') === 'random') {
            $start = Person::all()->sample()->first();
        } else {
            $start = Person::findOrNull(request('start'))
                ?? Auth::user()?->person()
                ?? Person::all()->sample()->first();
        }

        $plot = new Plot($start);

        return view('tree', compact('start', 'plot'));
    }

    public function info(): Response
    {
        return view('info', [
            'families' => Family::all(),
            'people' => Person::all(),
        ]);
    }
}

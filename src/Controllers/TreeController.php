<?php

namespace App\Controllers;

use App\Models\Family;
use App\Models\Person;
use App\Plot\Plot;
use Exception;
use PXP\Http\Controllers\Controller;
use PXP\Lib\Auth;
use PXP\Router\Router;

class TreeController extends Controller
{
    public function tree()
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

    public function info()
    {
        return view('info', [
            'families' => Family::all(),
            'people' => Person::all(),
        ]);
    }
}

<?php

namespace App\Controllers;

use App\Models\Person;
use App\Models\Family;
use Exception;
use PXP\Core\Controllers\Controller;
use App\Plot\Plot;
use PXP\Core\Lib\Router;

class TreeController extends Controller
{
    public function tree()
    {
        $start = Person::findByOrNull('identifier', request('start'))
            ?? Person::findByOrNull('identifier', perma('tree.start'))
            ?? Person::all()->sample()->first();

        if(request('start') === 'random') {
            $start = Person::all()->sample()->first();
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

    public function families()
    {
        return view('families', [
            'families' => Family::all(),
        ]);
    }

    public function person(string $id)
    {
        $person = Person::findByOrNull('identifier', $id);

        if($person === null) {
            throw new Exception("Person with id '$id' not found");
        }

        return view('person', compact('person'));
    }

    public function setStart(string $id)
    {
        $person = Person::findByOrNull('identifier', $id);

        if($person === null) {
            throw new Exception("Person with id '$id' not found");
        }

        perma(['tree.start' => $id]);

        Router::redirect("/tree");
    }
}

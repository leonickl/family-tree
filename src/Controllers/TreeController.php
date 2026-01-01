<?php

namespace App\Controllers;

use App\Tree;
use App\Types\Person;
use App\Types\Family;
use Exception;
use PXP\Core\Controllers\Controller;
use App\Plot\Plot;
use PXP\Core\Lib\Router;

class TreeController extends Controller
{
    public static function guard(string $tree)
    {
        if (! preg_match('/^[a-zA-Z-]+$/', $tree)) {
            throw new Exception("Invalid tree name '{$tree}'");
        }

        return Tree::init($tree);
    }

    public function tree(string $tree)
    {
        self::guard($tree);

        $start = Person::find(request('start'))
            ?? Person::find(perma("tree.$tree.start"))
            ?? Person::all()->sample()->first();

        if(request('start') === 'random') {
            $start = Person::all()->sample()->first();
        }

        $plot = new Plot($start);

        return view('tree', compact('tree', 'start', 'plot'));
    }

    public function info(string $tree)
    {
        self::guard($tree);

        return view('info', [
            'families' => Family::all(),
            'people' => Person::all(),
        ]);
    }

    public function families(string $tree)
    {
        self::guard($tree);

        return view('families', [
            'families' => Family::all(),
        ]);
    }

    public function person(string $tree, string $id)
    {
        self::guard($tree);

        $person = Person::find($id);

        if($person === null) {
            throw new Exception("Person with id '$id' not found");
        }

        return view('person', compact('person'));
    }

    public function setStart(string $tree, string $id)
    {
        self::guard($tree);

        $person = Person::find($id);

        if($person === null) {
            throw new Exception("Person with id '$id' not found");
        }

        perma(["tree.$tree.start" => $id]);

        Router::redirect("/trees/$tree");
    }
}

<?php

namespace App\Controllers;

use PXP\Core\Controllers\Controller;
use Exception;
use App\Tree;

class TreeController extends Controller
{
    public static function guard(string $tree)
    {
        if(! in_array($tree, ['Nickl', 'Bauer'])) {
            throw new Exception("Illegal tree name {$tree}");
        }

        return Tree::init($tree);
    }

    public function tree(string $tree)
    {
        $tree = self::guard($tree);

        $start = Tree::make()->person(request('start'));

        // select random person if none is given
        if($start === null) {
            $people = Tree::make()->people()->values();
            $index = random_int(0, count($people) - 1);            
            $start = $people[$index];
        }

        return view('tree', compact('tree', 'start'));
    }

    public function families(string $tree)
    {
        $tree = self::guard($tree);

        return view('families', compact('tree'));
    }
}

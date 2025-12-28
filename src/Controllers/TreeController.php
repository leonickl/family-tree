<?php

namespace App\Controllers;

use App\Tree;
use Exception;
use PXP\Core\Controllers\Controller;

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
        $tree = self::guard($tree);

        $start = Tree::make()->person(request('start'));

        // select random person if none is given
        if ($start === null) {
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

    public function info(string $tree)
    {
        $tree = self::guard($tree);

        return view('info', compact('tree'));
    }
}

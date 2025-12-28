<?php

namespace App\Controllers;

use PXP\Core\Controllers\Controller;

class ExampleController extends Controller
{
    public function index()
    {
        return view('main');
    }
}

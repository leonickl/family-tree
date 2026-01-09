<?php

namespace App\Controllers;

use PXP\Core\Controllers\Controller;

class MainController extends Controller
{
    public function index()
    {
        return view('main');
    }
}

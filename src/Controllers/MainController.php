<?php

namespace App\Controllers;

use PXP\Http\Controllers\Controller;

class MainController extends Controller
{
    public function index()
    {
        return view('main');
    }
}

<?php

namespace App\Controllers;

use PXP\Lib\Auth;
use PXP\Http\Controllers\Controller;
use PXP\Exceptions\ValidationException;
use PXP\Router\Router;

class MainController extends Controller
{
    public function index()
    {
        return view('main');
    }
}

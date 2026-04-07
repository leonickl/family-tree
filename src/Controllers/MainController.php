<?php

namespace App\Controllers;

use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Response;

class MainController extends Controller
{
    public function index(): Response
    {
        return view('main');
    }
}

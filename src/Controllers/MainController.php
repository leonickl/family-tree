<?php

namespace App\Controllers;

use PXP\Core\Controllers\Controller;

class MainController extends Controller
{
    public function index()
    {
        return view('main', [
            'trees' => c(...scandir(path('database/trees')))
                ->filter(fn($file) => ! str_starts_with($file, '.'))
                ->map(fn($file) => str_replace('.ged', '', $file)),
        ]);
    }
}

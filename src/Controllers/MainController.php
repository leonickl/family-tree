<?php

namespace App\Controllers;

use PXP\Core\Controllers\Controller;

class MainController extends Controller
{
    public function index()
    {
        $trees = c(...scandir(path('database/trees')))
            ->filter(fn($file) => ! str_starts_with($file, '.') && str_ends_with($file, '.json'))
            ->map(fn($file) => str_replace('.json', '', $file));

        return view('main', [
            'trees' => $trees,
        ]);
    }
}

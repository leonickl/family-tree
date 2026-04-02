<?php

namespace App\Controllers;

use PXP\Http\Controllers\Controller;

class AssetController extends Controller
{
    public function css(string $file)
    {
        if (! preg_match('/^[a-zA-Z-]+$/', $file)) {
            throw new Exception("Invalid CSS path '$file'");
        }

        header('Content-Type: text/css');

        return file_get_contents(path("assets/css/$file.css"));
    }
}

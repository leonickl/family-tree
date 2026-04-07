<?php

namespace App\Controllers;

use Exception;
use PXP\Http\Controllers\Controller;

class AssetController extends Controller
{
    public function css(string $file): string
    {
        if (! preg_match('/^[a-zA-Z-]+$/', $file)) {
            throw new Exception("Invalid CSS path '$file'");
        }

        header('Content-Type: text/css');

        $content = file_get_contents(path("assets/css/$file.css"));

        if (! $content) {
            throw new Exception("Reading CSS file '$file' unsuccessful");
        }

        return $content;
    }
}

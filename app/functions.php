<?php

use App\Tree;

function tree(?string $file = null)
{
    if ($file) {
        return Tree::init($file);
    }

    return Tree::make();
}

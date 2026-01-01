<?php

namespace App\Plot;

class Plot
{
    public function __construct(private \App\Types\Person $person) {}

    public function __toString()
    {
        $families = '';
        
        return "<div class=\"family\">$families</div>";
    }
}

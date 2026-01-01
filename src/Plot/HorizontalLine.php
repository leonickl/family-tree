<?php

namespace App\Plot;

readonly class HorizontalLine
{
    public function __construct(private int $y, private int $x, private ?int $xTo = null) {}

    public function __toString()
    {
        $location = implode(' / ', [
            $this->y,
            $this->x,
            $this->y + 1,
            $this->xTo ?? ($this->x + 1),
        ]);

        return "<div class=\"horizontal-connector\" style=\"grid-area: $location\"></div>";
    }
}

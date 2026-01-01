<?php

namespace App\Plot;

readonly class VerticalLine
{
    public function __construct(private int $y, private int $x) {}

    public function __toString()
    {
        $location = implode(' / ', [
            $this->y,
            $this->x,
            $this->y + 1,
            $this->x + 1,
        ]);

        return "<div class=\"vertical-connector\" style=\"grid-area: $location; \"></div>";
    }
}

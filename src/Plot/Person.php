<?php

namespace App\Plot;

class Person
{
    public function __construct(private ?\App\Types\Person $person, private int $y, private int $x, private bool $highlight = false) {}

    public function __toString()
    {
        $area = implode(' / ', [$this->y, $this->x, $this->y + 1, $this->x + 1]);

        $classes = 'px-1 py-05 rounded text-center-both';
        $styles = "grid-area: $area; z-index: 10";

        if ($this->highlight) {
            return "<div class=\"$classes bg-primary\" style=\"$styles; width: 10rem; color: #f9fafb\">$this->person</div>";
        }

        $link = lnk()->tree($this->person);

        return "<div class=\"$classes border\" style=\"$styles; background: var(--main-background); width: 10rem\">$link</div>";
    }
}
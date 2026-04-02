<?php

namespace App\Plot;

class Person
{
    public function __construct(private ?\App\Models\Person $person, private int $y, private int $x, private bool $highlight = false) {}

    public function __toString()
    {
        $area = implode(' / ', [$this->y, $this->x, $this->y + 1, $this->x + 1]);

        $classes = 'px-1 py-05 rounded text-center-both';
        $styles = "grid-area: $area; z-index: 10";
        
        $show = lnk()->show($this->person);

        if ($this->highlight) {
            return "<div class=\"person person-highlight $classes bg-primary\" style=\"$styles\">$this->person &nbsp; $show</div>";
        }

        $link = lnk()->tree($this->person);

        return "<div class=\"person $classes border\" style=\"$styles; background: var(--main-background)\">$link &nbsp; $show</div>";
    }
}

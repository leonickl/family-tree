<?php

namespace App\Plot;

class Person
{
    public function __construct(private ?\App\Types\Person $person, private int $y, private int $x, private bool $highlight = false) {}

    public function __toString()
    {
        return view('person', [
            'person' => $this->person,
            'highlight' => $this->highlight,
            'area' => [$this->y, $this->x, $this->y + 1, $this->x + 1],
        ]);
    }
}
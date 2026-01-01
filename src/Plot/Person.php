<?php

namespace App\Plot;

class Person
{
    public function __construct(private App\Types\Person $person, int $x, int $y) {}

    public function __toString()
    {
        return view('person', [
            'person' => $this->person,
            'start' => $start,
            'area' => [$this->y, $this->x, $this->y + 1, $this->x + 1],
        ])->render();
    }
}
<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;

class Event implements Arrayable
{
    public function __construct(private \Gedcom\Record\Indi\Even|\Gedcom\Record\Fam\Even $even) {}

    public function type()
    {
        return $this->even->getType();
    }

    public function date()
    {
        return $this->even->getDate();
    }

    public function place()
    {
        return $this->even->getPlac();
    }

    public function toArray()
    {
        return [
            'type' => $this->type(),
            'date' => $this->date(),
            'place' => $this->place(),
        ];
    }
}

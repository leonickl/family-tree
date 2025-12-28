<?php

namespace App\Types;

class Event
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
}

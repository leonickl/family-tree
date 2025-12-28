<?php

namespace App;

class Name
{
    public function __construct(private \Gedcom\Record\Indi\Name $name) {}

    public function name()
    {
        return $this->name->getName();
    }

    public function given()
    {
        return $this->name->getGivn();
    }

    public function surname()
    {
        return $this->name->getSurn();
    }

    public function __toString()
    {
        return $this->given().' '.$this->surname();
    }
}

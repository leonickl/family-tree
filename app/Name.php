<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;

class Name implements Arrayable
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

    public function toArray()
    {
        return [
            'name' => $this->name(),
            'given' => $this->given(),
            'surname' => $this->surname(),
        ];
    }
}

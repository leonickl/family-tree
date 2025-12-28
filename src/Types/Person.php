<?php

namespace App;

use Gedcom\Record\Indi;

class Person
{
    public function __construct(private Indi $indi) {}

    public function id()
    {
        return $this->indi->getId();
    }

    public function uid()
    {
        return $this->indi->getUid();
    }

    public function birth()
    {
        return Birth::make($this->indi->getBirt());
    }

    public function burial()
    {
        return Burial::make($this->indi->getBuri());
    }

    public function death()
    {
        return Death::make($this->indi->getDeat());
    }

    public function names()
    {
        return new Names($this->indi->getName());
    }

    public function sex()
    {
        return $this->indi->getSex();
    }

    public function attributes()
    {
        return collect($this->indi->getAllAttr());
    }

    public function events()
    {
        return collect($this->indi->getAllEven())
            ->flatten()
            ->map(fn ($event) => new Event($event));
    }

    public function associates()
    {
        return collect($this->indi->getAsso());
    }

    public function reference()
    {
        return $this->indi->getRfn();
    }

    public function notes()
    {
        return $this->indi->getNote();
    }

    public function __toString()
    {
        return $this->id().' - '.$this->names();
    }
}

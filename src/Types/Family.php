<?php

namespace App;

use Gedcom\Record\Fam;

class Family
{
    public function __construct(private Fam $fam) {}

    public function id()
    {
        return $this->fam->getId();
    }

    public function husband()
    {
        return tree()->person($this->fam->getHusb());
    }

    public function wife()
    {
        return tree()->person($this->fam->getWife());
    }

    public function children()
    {
        return collect($this->fam->getChil())
            ->map(fn (?string $id) => tree()->person($id));
    }

    public function events()
    {
        return collect($this->fam->getAllEven())
            ->flatten()
            ->map(fn ($event) => new Event($event));
    }

    public function notes()
    {
        return collect($this->fam->getNote());
    }

    public function __toString()
    {
        return $this->id();
    }
}

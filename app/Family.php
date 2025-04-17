<?php

namespace App;

use Gedcom\Record\Fam;
use Illuminate\Contracts\Support\Arrayable;

class Family implements Arrayable
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

    public function toArray()
    {
        return [
            'id' => $this->id(),
            'husband' => $this->husband()?->toArray(),
            'wife' => $this->wife()?->toArray(),
            'children' => $this->children()->toArray(),
            'events' => $this->events()->toArray(),
            'notes' => $this->notes()->toArray(),
        ];
    }
}

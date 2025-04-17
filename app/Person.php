<?php

namespace App;

use Gedcom\Record\Indi;
use Illuminate\Contracts\Support\Arrayable;

class Person implements Arrayable
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

    public function toArray()
    {
        return [
            'id' => $this->id(),
            'birth' => $this->birth()?->toArray(),
            'burial' => $this->burial()?->toArray(),
            'death' => $this->death()?->toArray(),
            'names' => $this->names()->toArray(),
            'sex' => $this->sex(),
            'attributes' => $this->attributes()->toArray(),
            'events' => $this->events()->toArray(),
            'associates' => $this->associates()->toArray(),
            'reference' => $this->reference(),
            'notes' => $this->notes(),
        ];
    }
}

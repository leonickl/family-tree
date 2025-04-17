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

    public function birthday()
    {
        return $this->indi->getBirt();
    }

    public function burial()
    {
        return $this->indi->getBuri();
    }

    public function death()
    {
        return $this->indi->getDeat();
    }

    public function name()
    {
        $names = collect($this->indi->getName())
            ->map(fn (\Gedcom\Record\Indi\Name $name) => new Name($name));

        return new Names($names);
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
        return $this->id().' - '.$this->name();
    }

    public function toArray()
    {
        return [
            'id' => $this->id(),
            'uid' => $this->uid(),
            'birthday' => $this->birthday(),
            'burial' => $this->burial(),
            'death' => $this->death(),
            'name' => $this->name()->toArray(),
            'sex' => $this->sex(),
            'attributes' => $this->attributes()->toArray(),
            'events' => $this->events()->toArray(),
            'associates' => $this->associates()->toArray(),
            'reference' => $this->reference(),
            'notes' => $this->notes(),
        ];
    }
}

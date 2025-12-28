<?php

namespace App\Types;

use Gedcom\Record\Indi;
use App\Tree;

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
        return c(...$this->indi->getAllAttr());
    }

    public function events()
    {
        return c(...$this->indi->getAllEven())
            ->flatten()
            ->map(fn ($event) => new Event($event));
    }

    public function associates()
    {
        return c(...$this->indi->getAsso());
    }

    public function reference()
    {
        return $this->indi->getRfn();
    }

    public function notes()
    {
        return $this->indi->getNote();
    }


    public function families()
    {
        return Tree::make()->families()->filter(function($family) {
            if($family->husband()?->id() === $this->id()) {
                return true;
            }

            if($family->wife()?->id() === $this->id()) {
                return true;
            }

            foreach($family->children() as $child) {
                if($child->id() === $this->id()) {
                    return true;
                }
            }

            return false;
        });
    }

    public function __toString()
    {
        if(trim($this->names()) === '') {
            return '---';
        }

        return $this->names();
    }
}

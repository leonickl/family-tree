<?php

namespace App\Types;

use App\Tree;

class Person
{
    public function __construct(private object $entity) {}

    public function id()
    {
        return substr($this->entity->id, 1, -1);
    }

    public function birth()
    {
        return Birth::make(@$this->entity->BIRT);
    }

    public function burial()
    {
        return Burial::make(@$this->entity->BURI);
    }

    public function death()
    {
        return Death::make(@$this->entity->DEAT);
    }

    public function names()
    {
        return new Names(@$this->entity->NAME);
    }

    public function sex()
    {
        return @$this->entity->SEX;
    }

    public function attributes()
    {
        return c(...$this->entity->ATTR ?? []);
    }

    public function notes()
    {
        return @$this->entity->NOTES;
    }

    public function events()
    {
        return c(...$this->entity->EVEN ?? [])
            ->flatten()
            ->map(fn ($event) => new Event($event));
    }

    public function childFamilies()
    {
        return Tree::make()->families()->filter(function ($family) {
            foreach ($family->children() as $child) {
                if ($child->id() === $this->id()) {
                    return true;
                }
            }

            return false;
        });
    }

    public function childFamilies2()
    {
        return c(...$this->entity->getFamc())
            ->map(fn($fam) => ChildFamily::make($fam)?->family())
            ->filter();
    }

    public function spousalFamilies()
    {
        return Tree::make()->families()->filter(function ($family) {
            if ($family->husband()?->id() === $this->id()) {
                return true;
            }

            if ($family->wife()?->id() === $this->id()) {
                return true;
            }

            return false;
        });
    }

    public function spousalFamilies2()
    {
        return c(...$this->entity->getFams())
            ->map(fn($fam) => SpousalFamily::make($fam)?->family())
            ->filter();
    }

    public function families()
    {
        return Tree::make()->families()->filter(function ($family) {
            if ($family->husband()?->id() === $this->id()) {
                return true;
            }

            if ($family->wife()?->id() === $this->id()) {
                return true;
            }

            foreach ($family->children() as $child) {
                if ($child->id() === $this->id()) {
                    return true;
                }
            }

            return false;
        });
    }

    public function __toString()
    {
        if (trim($this->names()) === '') {
            return '---';
        }

        return $this->names();
    }
}

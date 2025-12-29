<?php

namespace App\Types;

use App\Tree;

class Person
{
    public function __construct(private object $entity) {}

    public static function all()
    {
        return Tree::make()
            ->entities()
            ->filter(fn($entity) => @$entity->type === 'INDI')
            ->map(fn ($entity) => new Person($entity));
    }

    public static function find(?string $id)
    {
        if($id === null) {
            return null;
        }
        
        if($id[0] === '@') {
            $id = substr($id, 1, -1);
        }

        return Person::all()
            ->filter(fn(Person $person) => $person->id() === $id)
            ->values()[0] ?? null;
    }

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
        return c(...@$this->entity->FAMC ?? [])
            ->map(fn($fam) => Family::find($fam))
            ->filter();
    }

    public function spousalFamilies()
    {
        return c(...@$this->entity->FAMS ?? [])
            ->map(fn($fam) => Family::find($fam))
            ->filter();
    }

    public function partners()
    {
        return $this->spousalFamilies()
            ->map(fn($fam) => $fam->husband()?->id() === $this->id() ? $fam->wife() : $fam->husband());
    }

    public function siblings()
    {
        return $this->childFamilies()
            ->map(fn($fam) => $fam->children()->filter(fn($child) => $child?->id() !== $this->id()))
            ->flatten();
    }

    public function __toString()
    {
        if (trim($this->names()) === '') {
            return '---';
        }

        return $this->names();
    }

    public function dd()
    {
        dd($this);
    }
}

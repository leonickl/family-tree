<?php

namespace App\Types;

use App\Tree;

class Family
{
    public function __construct(private object $entity) {}

    public static function all()
    {
        return Tree::make()
            ->entities()
            ->filter(fn($entity) => @$entity->type === 'FAM')
            ->map(fn ($entity) => new Family($entity));
    }

    public static function find(?string $id)
    {
        if($id === null) {
            return null;
        }

        if($id[0] === '@') {
            $id = substr($id, 1, -1);
        }

        return Family::all()
            ->filter(fn(Family $family) => $family->id() === $id)
            ->values()[0] ?? null;
    }

    public function id()
    {
        return @substr($this->entity->id, 1, -1);
    }

    public function husband()
    {
        return Person::find(@$this->entity->HUSB);
    }

    public function wife()
    {
        return Person::find(@$this->entity->WIFE);
    }

    public function children()
    {
        return c(...@$this->entity->CHIL ?? [])
            ->map(fn (?string $id) => Person::find($id))
            ->filter();
    }

    public function events()
    {
        return c(...@$this->entity->EVEN ?? [])
            ->flatten()
            ->map(fn ($event) => new Event($event));
    }

    public function __toString()
    {
        $husband = lnk()->tree($this->husband());
        $wife = lnk()->tree($this->wife());
        $children = $this->children()
            ->map(fn ($child) => lnk()->tree($child))
            ->join(', ');

        return $husband.' + '.$wife.($children ? ' = '.$children : '');
    }

    public function dd()
    {
        dd($this);
    }
}

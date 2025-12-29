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
        return $id
            ? Family::all()
                ->filter(fn(Family $family) => $family->id() === $id)[0]
                    ?? null
            : null;
    }

    public function id()
    {
        return @$this->entity->ID;
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
            ->map(fn (?string $id) => Person::find($id));
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
}

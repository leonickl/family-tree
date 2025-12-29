<?php

namespace App\Types;

use App\Tree;

class Family
{
    public function __construct(private object $entity) {}

    public function id()
    {
        return @$this->entity->ID;
    }

    public function husband()
    {
        return Tree::make()->person(@$this->entity->HUSB);
    }

    public function wife()
    {
        return Tree::make()->person(@$this->entity->WIFE);
    }

    public function children()
    {
        return c(...@$this->entity->CHIL ?? [])
            ->map(fn (?string $id) => Tree::make()->person($id));
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

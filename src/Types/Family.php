<?php

namespace App\Types;

use Gedcom\Record\Fam;
use App\Tree;

class Family
{
    public function __construct(private Fam $fam) {}

    public function id()
    {
        return $this->fam->getId();
    }

    public function husband()
    {
        return Tree::make()->person($this->fam->getHusb());
    }

    public function wife()
    {
        return Tree::make()->person($this->fam->getWife());
    }

    public function children()
    {
        return c(...$this->fam->getChil())
            ->map(fn (?string $id) => Tree::make()->person($id));
    }

    public function events()
    {
        return c(...$this->fam->getAllEven())
            ->flatten()
            ->map(fn ($event) => new Event($event));
    }

    public function notes()
    {
        return c(...$this->fam->getNote());
    }

    public function __toString()
    {
        $husband = $this->husband() ?? '---';
        $wife = $this->wife() ?? '---';
        $children = $this->children()->join(', ');

        return $husband.' + '.$wife.($children ? ' = '.$children : '');
    }
}

<?php

namespace App\Types;

use App\Tree;

class ChildFamily
{
    private function __construct(private \Gedcom\Record\Indi\Famc $famc) {}

    public static function make(?\Gedcom\Record\Indi\Famc $famc)
    {
        return $famc ? new self($famc) : null;
    }

    public function family()
    {
        return Tree::make()->family($this->famc->getFamc());
    }
}

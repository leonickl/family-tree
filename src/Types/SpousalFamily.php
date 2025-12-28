<?php

namespace App\Types;

use App\Tree;

class SpousalFamily
{
    private function __construct(private \Gedcom\Record\Indi\Fams $fams) {}

    public static function make(?\Gedcom\Record\Indi\Fams $fams)
    {
        return $fams ? new self($fams) : null;
    }

    public function family()
    {
        return Tree::make()->family($this->fams->getFams());
    }
}

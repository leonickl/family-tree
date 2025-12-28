<?php

namespace App\Types;

class Death
{
    private function __construct(private \Gedcom\Record\Deat $death) {}

    public static function make(?\Gedcom\Record\Deat $death)
    {
        return $death ? new self($death) : null;
    }

    public function date()
    {
        return Date::make($this->death->getDate());
    }
}

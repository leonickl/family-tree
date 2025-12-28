<?php

namespace App;

class Birth
{
    private function __construct(private \Gedcom\Record\Birt $birth) {}

    public static function make(?\Gedcom\Record\Birt $birth)
    {
        return $birth ? new self($birth) : null;
    }

    public function date()
    {
        return Date::make($this->birth->getDate());
    }
}

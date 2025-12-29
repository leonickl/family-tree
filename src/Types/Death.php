<?php

namespace App\Types;

class Death
{
    private function __construct(private object $death) {}

    public static function make(object|array|null $death)
    {
        return $death ? new self((object)$death) : null;
    }

    public function date()
    {
        return Date::make(@$this->death->DATE);
    }

    public function place()
    {
        return @$this->death->PLAC;
    }
}

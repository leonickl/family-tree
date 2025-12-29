<?php

namespace App\Types;

class Burial
{
    private function __construct(private object $burial) {}

    public static function make(object|array|null $burial)
    {
        return $burial ? new self((object)$burial) : null;
    }

    public function date()
    {
        return Date::make(@$this->burial->DATE);
    }

    public function place()
    {
        return @$this->burial->PLAC;
    }
}

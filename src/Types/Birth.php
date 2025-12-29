<?php

namespace App\Types;

class Birth
{
    private function __construct(private object $birth) {}

    public static function make(object|array|null $birth)
    {
        return $birth ? new self((object)$birth) : null;
    }

    public function date()
    {
        return Date::make(@$this->birth->DATE);
    }

    public function place()
    {
        return @$this->birth->PLAC;
    }
}

<?php

namespace App\Types;

class Names
{
    public function __construct(private object $names) {}

    public function all()
    {
        return c(...(array)$this->names)
            ->map(fn (string $name, string $type) => new Name($type, $name));
    }

    public function full()
    {
        return $this->all()['.'];
    }

    public function given()
    {
        return $this->all()['GIVN'];
    }

    public function surname()
    {
        return $this->all()['SURN'];
    }

    public function __toString()
    {
        return $this->full();
    }
}

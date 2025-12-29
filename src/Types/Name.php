<?php

namespace App\Types;

class Name
{
    public function __construct(private string $type, private string $name) {}

    public function type()
    {
        return $this->type;
    }

    public function name()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name();
    }
}

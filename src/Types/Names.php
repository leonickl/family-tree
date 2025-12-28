<?php

namespace App\Types;

class Names
{
    public function __construct(private array $names) {}

    public function all()
    {
        return c(...$this->names)
            ->map(fn (\Gedcom\Record\Indi\Name $name) => new Name($name));
    }

    public function __toString()
    {
        return $this->all()->map(fn (Name $name) => (string) $name)->join(', ');
    }
}

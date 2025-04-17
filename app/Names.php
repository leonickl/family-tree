<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class Names implements Arrayable
{
    public function __construct(private Collection $names) {}

    public function all()
    {
        return $this->names;
    }

    public function __toString()
    {
        return $this->all()->map(fn (Name $name) => (string) $name)->implode(', ');
    }

    public function toArray()
    {
        return $this->all()->toArray();
    }
}

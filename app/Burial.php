<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;

class Burial implements Arrayable
{
    private function __construct(private \Gedcom\Record\Buri $burial) {}

    public static function make(?\Gedcom\Record\Buri $burial)
    {
        return $burial ? new self($burial) : null;
    }

    public function date()
    {
        return Date::make($this->burial->getDate());
    }

    public function toArray()
    {
        return [
            'date' => $this->date()?->toArray(),
        ];
    }
}

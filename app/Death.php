<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;

class Death implements Arrayable
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

    public function toArray()
    {
        return [
            'date' => $this->date()?->toArray(),
        ];
    }
}

<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;

class Birth implements Arrayable
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

    public function toArray()
    {
        return [
            'date' => $this->date()?->toArray(),
        ];
    }
}

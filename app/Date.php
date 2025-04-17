<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;

class Date implements Arrayable
{
    private function __construct(private string $date) {}

    public static function make(?string $date)
    {
        return $date ? new Date($date) : null;
    }

    public function toArray()
    {
        return [
            'date' => $this->date,
        ];
    }
}

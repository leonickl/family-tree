<?php

namespace App;

class Date
{
    private function __construct(private string $date) {}

    public static function make(?string $date)
    {
        return $date ? new Date($date) : null;
    }
}

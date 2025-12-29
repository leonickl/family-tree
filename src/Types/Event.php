<?php

namespace App\Types;

class Event
{
    public function __construct(private object $event) {}

    public function type()
    {
        return @$this->event->TYPE;
    }

    public function date()
    {
        return Date::make(@$this->event->DATE);
    }

    public function place()
    {
        return @$this->event->PLAC;
    }
}

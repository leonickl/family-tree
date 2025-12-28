<?php

namespace App;

use Gedcom\Gedcom;
use Gedcom\Record\Fam;
use Gedcom\Record\Indi;
use App\Types\Person;
use App\Types\Family;

class Tree
{
    private static Tree $instance;

    private function __construct(private Gedcom $parser) {}

    public static function init(string $file = 'tree')
    {
        $parsed = new \Gedcom\Parser()
            ->parse(path('database/trees/'.$file.'.ged'));

        return self::$instance = new self($parsed);
    }

    public static function make()
    {
        return self::$instance;
    }

    public function families()
    {
        return c(...$this->parser->getFam())
            ->map(fn (Fam $fam) => new Family($fam));
    }

    public function family(?string $id)
    {
        return $id ? $this->families()[$id] : null;
    }

    public function people()
    {
        return c(...$this->parser->getIndi())
            ->map(fn (Indi $indi) => new Person($indi));
    }

    public function person(?string $id)
    {
        return $id ? $this->people()[$id] : null;
    }
}

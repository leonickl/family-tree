<?php

namespace App;

use Gedcom\Gedcom;
use Gedcom\Record\Fam;
use Gedcom\Record\Indi;

class Tree
{
    private static Tree $instance;

    private function __construct(private Gedcom $parser) {}

    public static function init(string $file = 'tree')
    {
        return self::$instance = new self((new \Gedcom\Parser)->parse(storage_path('trees/' . $file . '.ged')));
    }

    public static function make()
    {
        return self::$instance;
    }

    public function families()
    {
        return collect($this->parser->getFam())
            ->map(fn (Fam $fam) => new Family($fam));
    }

    public function family(?string $id)
    {
        return $id ? $this->families()[$id] : null;
    }

    public function people()
    {
        return collect($this->parser->getIndi())
            ->map(fn (Indi $indi) => new Person($indi));
    }

    public function person(?string $id)
    {
        return $id ? $this->people()[$id] : null;
    }
}

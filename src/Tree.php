<?php

namespace App;

use App\Types\Family;
use App\Types\Person;

class Tree
{
    private static Tree $instance;

    private function __construct(private array $tree, public string $file) {}

    public static function init(string $file)
    {
        $tree = json_decode(file_get_contents(path("database/trees/$file.json")));

        if($tree === false || ! is_array($tree)) {
            throw new Exception('invalid json');
        }

        return self::$instance = new self($tree, $file);
    }

    public static function make()
    {
        if(! isset(self::$instance)) {
            throw new Exception('initialize tree before usage');
        }

        return self::$instance;
    }

    private function entities()
    {
        return c(...$this->tree);
    }

    public function families()
    {
        return $this->entities()
            ->filter(fn($entity) => @$entity->type === 'FAM')
            ->map(fn ($entity) => new Family($entity));
    }

    public function family(?string $id)
    {
        if(! $id) {
            return null;
        }

        return $this->families()
            ->filter(fn(Family $family) => $family->id() === $id)[0] ?? null;
    }

    public function people()
    {
        return $this->entities()
            ->filter(fn($entity) => @$entity->type === 'INDI')
            ->map(fn ($entity) => new Person($entity));
    }

    public function person(?string $id)
    {
        if(! $id) {
            return null;
        }

        return $this->people()
            ->filter(fn(Person $person) => $person->id() === $id)[0] ?? null;
    }
}

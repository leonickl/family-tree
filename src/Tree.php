<?php

namespace App;

use Exception;

class Tree
{
    private static Tree $instance;

    private function __construct(private array $tree, public string $file) {}

    public static function init(string $file)
    {
        $tree = json_decode(file_get_contents(path("database/trees/$file.json")));

        if ($tree === false || ! is_array($tree)) {
            throw new Exception('invalid json');
        }

        return self::$instance = new self($tree, $file);
    }

    public static function make()
    {
        if (! isset(self::$instance)) {
            throw new Exception('initialize tree before usage');
        }

        return self::$instance;
    }

    public function entities()
    {
        return c(...$this->tree);
    }
}

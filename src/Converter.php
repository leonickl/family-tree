<?php

namespace App;

use Exception;

class Converter
{
    private array $parsed = [];

    private ?array $state = null;

    private ?array $substate = null;

    private ?array $subsubstate = null;

    private ?array $subsubsubstate = null;

    private function __construct(private array $lines) {}

    public static function read(string $file)
    {
        $raw = @file_get_contents($file);

        if (! $raw) {
            exit("File '$file' not found\n");
        }

        return self::raw($raw);
    }

    public static function raw(string $raw)
    {
        return new self(explode("\n", $raw));
    }

    public function convert()
    {
        foreach ($this->lines as $line) {
            $this->convertLine($line);
        }

        return $this;
    }

    private function convertLine(string $line)
    {
        $parts = explode(' ', $line, 3);
        $level = trim($parts[0], "\u{feff}");

        if ($level === '0') {
            if ($this->state !== null) {
                $this->parsed[] = $this->state;
            }

            $this->state = ['id' => $parts[1]];

            if (isset($parts[2])) {
                $this->state['type'] = $parts[2];
            }
        } elseif ($level === '1') {
            if ($this->state === null) {
                throw new Exception('cannot have 1 at null-state');
            }

            $this->saveSubSubSubState();
            $this->saveSubSubState();
            $this->saveSubState();

            $this->substate = [$parts[1] => $parts[2] ?? null];
        } elseif ($level === '2') {
            if ($this->state === null) {
                throw new Exception('cannot have 2 at null-state');
            }

            if ($this->substate === null) {
                throw new Exception('cannot have 2 at null-substate');
            }

            $this->saveSubSubSubState();
            $this->saveSubSubState();

            $this->subsubstate = [$parts[1] => $parts[2] ?? null];
        } elseif ($level === '3') {
            if ($this->state === null) {
                throw new Exception('cannot have 3 at null-state');
            }

            if ($this->substate === null) {
                throw new Exception('cannot have 2 at null-substate');
            }

            if ($this->subsubstate === null) {
                throw new Exception('cannot have 2 at null-subsubstate');
            }

            $this->saveSubSubSubState();

            $this->subsubsubstate = [$parts[1] => $parts[2] ?? null];
        } else {
            throw new Exception("illegal indentation level '$level'");
        }
    }

    private function saveSubSubSubState()
    {
        if ($this->subsubsubstate !== null) {
            $this->subsubstate['subsubsub'][] = $this->subsubsubstate;
            $this->subsubsubstate = null;
        }
    }

    private function saveSubSubState()
    {
        if ($this->subsubstate !== null) {
            $this->substate['subsub'][] = $this->subsubstate;
            $this->subsubstate = null;
        }
    }

    private function saveSubState()
    {
        if ($this->substate !== null) {
            $this->state['sub'][] = $this->substate;
            $this->substate = null;
        }
    }

    public function simplify()
    {
        $entities = [];

        // loop over [head, ...people, ...families, ...sources, ...]
        foreach ($this->parsed as $entity) {
            $entityNew = [];

            // loop over attributes [id, name, sex, ...]
            foreach ($entity as $attributeKey => $attributeValue) {
                if ($attributeKey !== 'sub') {
                    $entityNew[$attributeKey][] = $attributeValue;

                    continue;
                }

                // flatten out nested attributes of first order
                foreach ($attributeValue as $sub) {
                    $subLabel = null;
                    $subContent = null;

                    foreach ($sub as $subKey => $subValue) {
                        if ($subKey !== 'subsub') {
                            $subLabel = $subKey;
                            $subContent = ['.' => $subValue];
                            $subFirst = false;

                            continue;
                        }

                        // flatten out second-order-nesting
                        foreach ($subValue as $subsub) {
                            $subsubLabel = null;
                            $subsubContent = null;
                            $subsubFirst = true;

                            // flatten out third-order-nesting
                            foreach ($subsub as $subsubKey => $subsubValue) {
                                if ($subsubKey !== 'subsubsub') {
                                    $subsubLabel = $subsubKey;
                                    $subsubContent = ['.' => $subsubValue];
                                    $subsubFirst = false;

                                    continue;
                                }

                                // third order is always scalar (no more nesting)
                                $subsubContent = array_merge($subsubContent, ...$subsubValue);
                            }

                            $subContent[$subsubLabel][] = $this->simplifyAttributes($subsubContent);
                        }
                    }

                    $entityNew[$subLabel][] = $this->simplifyAttributes($subContent);
                }
            }

            $entities[] = $this->simplifyAttributes($entityNew);
        }

        $this->parsed = $entities;

        return $this;
    }

    private function simplifyAttributes(array $attributes)
    {
        $attributes = array_filter($attributes);

        $values = array_map(function ($key, $value) {
            if (! is_array($value)) {
                return $value;
            }

            if ($key === 'NAME') {
                $value[0]['.'] = trim(str_replace('/', '', $value[0]['.']));
            }

            if (in_array($key, ['id', 'type', 'BIRT', 'BURI', 'DEAT', 'DATA', 'NAME'])) {
                if (count($value) > 1) {
                    throw new Exception("too many nodes found for '$key'");
                }

                return $value[0];
            }

            if (in_array($key, [
                'VERS', 'FORM', 'CHAR', 'LANG', 'DEST', 'DATE', 'CORP', 'DATE',
                'FILE', '_PROJECT_GUID', 'GIVN', 'SURN', '_MARNM', 'SEX', 'AGE',
                'RIN', 'PLAC', 'PAGE', 'QUAY', 'HUSB', 'WIFE', 'TYPE', 'AUTH',
                'TITL', 'TEXT', '_TYPE', '_MEDI', 'CAUS', 'NPFX', 'NSFX',
            ])) {
                if (count($value) > 1 || count($value[0]) > 1) {
                    throw new Exception("too many nodes found for '$key'");
                }

                if (! array_key_exists('.', $value[0])) {
                    throw new Exception("key '.' not found");
                }

                return $value[0]['.'];
            }

            if (in_array($key, ['FAMC', 'FAMS', '_UID', 'CONC', 'CHIL'])) {
                return array_map(fn ($item) => $item['.'], $value);
            }

            return $value;
        }, array_keys($attributes), array_values($attributes));

        return array_combine(array_keys($attributes), $values);
    }

    public function get()
    {
        return $this->parsed;
    }
}

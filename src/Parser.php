<?php

namespace App;

use Exception;

class Parser
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

        if(! $raw) {
            die("File '$file' not found\n");
        }

        return self::raw($raw);
    }

    public static function raw(string $raw)
    {
        return new self(explode("\n", $raw));
    }

    public function parse()
    {
        foreach($this->lines as $line) {
            $this->parseLine($line);
        }

        return $this;
    }

    private function parseLine(string $line)
    {
        $parts = explode(' ', $line, 3);

        if($parts[0] === '0') {
            if($this->state !== null) {
                $this->parsed[] = $this->state;
            }

            $this->state = ['id' => $parts[1]];

            if(isset($parts[2])) {
                $this->state['type'] = $parts[2];
            }
        }

        elseif($parts[0] === '1') {
            if($this->state === null) {
                throw new Exception('cannot have 1 at null-state');
            }

            $this->saveSubSubSubState();
            $this->saveSubSubState();
            $this->saveSubState();

            $this->substate = [$parts[1] => $parts[2] ?? null];
        }

        elseif($parts[0] === '2') {
            if($this->state === null) {
                throw new Exception('cannot have 2 at null-state');
            }

            if($this->substate === null) {
                throw new Exception('cannot have 2 at null-substate');
            }

            $this->saveSubSubSubState();
            $this->saveSubSubState();

            $this->subsubstate = [$parts[1] => $parts[2] ?? null];
        }

        elseif($parts[0] === '3') {
            if($this->state === null) {
                throw new Exception('cannot have 3 at null-state');
            }

            if($this->substate === null) {
                throw new Exception('cannot have 2 at null-substate');
            }

            if($this->subsubstate === null) {
                throw new Exception('cannot have 2 at null-subsubstate');
            }

            $this->saveSubSubSubState();

            $this->subsubsubstate = [$parts[1] => $parts[2] ?? null];
        }

        else {
            throw new Exception('illegal indentation level');
        }
    }

    private function saveSubSubSubState()
    {
        if($this->subsubsubstate !== null) {
            $this->subsubstate['subsubsub'][] = $this->subsubsubstate;
            $this->subsubsubstate = null;
        }
    }

    private function saveSubSubState()
    {
        if($this->subsubstate !== null) {
            $this->substate['subsub'][] = $this->subsubstate;
            $this->subsubstate = null;
        }
    }

    private function saveSubState()
    {
        if($this->substate !== null) {
            $this->state['sub'][] = $this->substate;
            $this->substate = null;
        }
    }

    public function simplify()
    {
        $entities = [];

        // loop over [head, ...people, ...families, ...sources, ...]
        foreach($this->parsed as $entity) {
            $entityNew = [];

            // loop over attributes [id, name, sex, ...]
            foreach($entity as $attributeKey => $attributeValue) {
                if($attributeKey !== 'sub') {
                    $entityNew[$attributeKey][] = $attributeValue;

                    continue;
                }

                // flatten out nested attributes of first order
                foreach($attributeValue as $sub) {
                    $subLabel = null;
                    $subContent = null;

                    foreach($sub as $subKey => $subValue) {
                        if($subKey !== 'subsub') {
                            $subLabel = $subKey;
                            $subContent = ['.' => $subValue];
                            $subFirst = false;

                            continue;
                        }

                        // flatten out second-order-nesting
                        foreach($subValue as $subsub) {
                            $subsubLabel = null;
                            $subsubContent = null;
                            $subsubFirst = true;

                            // flatten out third-order-nesting
                            foreach($subsub as $subsubKey => $subsubValue) {
                                if($subsubKey !== 'subsubsub') {
                                    $subsubLabel = $subsubKey;
                                    $subsubContent = ['.' => $subsubValue];
                                    $subsubFirst = false;

                                    continue;
                                }

                                // third order is always scalar (no more nesting)
                                $subsubContent = array_merge($subsubContent, ...$subsubValue);
                            }

                            $subContent[$subsubLabel][] = array_filter($subsubContent);
                        }
                    }

                    $entityNew[$subLabel][] = array_filter($subContent);
                }
            }

            $entities[] = array_filter($entityNew);
        }

        $this->parsed = $entities;

        return $this;
    }

    public function get()
    {
        return $this->parsed;
    }
}

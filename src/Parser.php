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

            $this->state = ['id' => $parts[1], 'type' => $parts[2] ?? '---'];
        }

        elseif($parts[0] === '1') {
            if($this->state === null) {
                throw new Exception('cannot have 1 at null-state');
            }

            $this->saveSubSubSubState();
            $this->saveSubSubState();
            $this->saveSubState();

            $this->substate = [$parts[1] => $parts[2] ?? '---'];
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

            $this->subsubstate = [$parts[1] => $parts[2] ?? '---'];
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

            $this->subsubsubstate = [$parts[1] => $parts[2]];
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

        foreach($this->parsed as $entity) {
            $entityNew = [];

            foreach($entity as $attributeKey => $attributeValue) {
                if($attributeKey === 'sub') {                    
                    foreach($attributeValue as $sub) {
                        $subLabel = null;
                        $subContent = null;
                        $subFirst = true;

                        foreach($sub as $subKey => $subValue) {
                            if($subFirst) {
                                $subLabel = $subKey;
                                $subContent = ['.' => $subValue];
                                $subFirst = false;
                            }

                            elseif($subKey === 'subsub') {
                                foreach($subValue as $subsub) {
                                    $subsubLabel = null;
                                    $subsubContent = null;
                                    $subsubFirst = true;

                                    foreach($subsub as $subsubKey => $subsubValue) {
                                        if($subsubFirst) {
                                            $subsubLabel = $subsubKey;
                                            $subsubContent = ['.' => $subsubValue];
                                            $subsubFirst = false;
                                        }

                                        elseif($subsubKey === 'subsubsub') {
                                            $subsubContent = [...$subsubContent, ...$subsubValue];
                                        }

                                        else {
                                            throw new Exception("unexpected key '$subsubKey'");
                                        }
                                    }

                                    $subContent[$subsubLabel][] = $subsubContent;
                                }
                            }

                            else {
                                throw new Exception("unexpected key '$subKey'");
                            }
                        }

                        $entityNew[$subLabel][] = $subContent;
                    }
                }
                
                else {
                    $entityNew[$attributeKey][] = $attributeValue;
                }
            }

            $entities[] = $entityNew;
        }

        $this->parsed = $entities;

        return $this;
    }

    public function get()
    {
        return $this->parsed;
    }
}

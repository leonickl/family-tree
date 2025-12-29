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
            if(! array_key_exists('subsubsub', $this->state)) {
                $this->state['subsubsub'] = [];
            }

            $this->subsubstate['subsubsub'][] = $this->subsubsubstate;
            $this->subsubsubstate = null;
        }
    }

    private function saveSubSubState()
    {
        if($this->subsubstate !== null) {
            if(! array_key_exists('subsub', $this->state)) {
                $this->state['subsub'] = [];
            }

            $this->substate['subsub'][] = $this->subsubstate;
            $this->subsubstate = null;
        }
    }

    private function saveSubState()
    {
        if($this->substate !== null) {
            if(! array_key_exists('props', $this->state)) {
                $this->state['props'] = [];
            }

            $this->state['props'][] = $this->substate;
            $this->substate = null;
        }
    }

    public function get()
    {
        return $this->parsed;
    }
}

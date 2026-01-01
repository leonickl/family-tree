<?php

namespace App\Plot;

class Plot
{
    public function __construct(private \App\Types\Person $person) {}

    public function __toString()
    {
        $people = [];
        $lines = [];

        $spousalFamilies = $this->person->spousalFamilies();
        $childFamilies = $this->person->childFamilies();

        $height = 3;

        $width = array_sum(
            $spousalFamilies->map(fn($family) => max(1, count($family->children())))
                ->toArray(),
        );

        $x = 1;

        foreach($spousalFamilies as $i => $family) {
            $people[] = new Person(
                $this->person->id() === $family->husband()?->id()
                    ? $family->wife() : $family->husband(),
                y: 2,
                x: $x + floor(count($family->children()) / 2),
            );

            $parentEnd = $x + floor(count($family->children()) / 2) + 1;

            foreach($family->children() as $j => $child) {
                $people[] = new Person($child, y: 3, x: $x++);

                if($j < count($family->children()) - 1) {
                    $lines[] = new Line(y: 3, x: $x);
                }
            }

            $lines[] = new Line(
                y: 2,
                x: $parentEnd ?: $x,
                xTo: $x + ($spousalFamilies->keys()->includes($i + 1)
                    ? $spousalFamilies[$i + 1]?->children()->count() ?? 1 : 1),
            );
        }

        $people[] = new Person($this->person, y: 2, x: $x++, highlight: true);

        foreach($childFamilies as $family) {
            if(count($family->children()) > 1) {
                $lines[] = new Line(y: 2, x: $x);
            }

            $people[] = new Person($family->husband(), y: 1, x: $x + floor(count($family->children()) / 2) - 1);
            $lines[] = new Line(y: 1, x: $x + floor(count($family->children()) / 2));
            $people[] = new Person($family->wife(), y: 1, x: $x + floor(count($family->children()) / 2));

            foreach($family->children()->filter(fn($child) => $child->id() !== $this->person->id()) as $child) {
                $lines[] = new Line(y: 2, x: $x);
                $people[] = new Person($child, y: 2, x: $x++);
            }
        }

        return '<div class="family">'
            .implode($people)
            .implode($lines)
            .'</div>';
    }
}

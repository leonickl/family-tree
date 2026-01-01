<?php

namespace App\Plot;

class Plot
{
    public function __construct(private \App\Types\Person $person) {}

    public function __toString()
    {
        $objects = [];

        $spousalFamilies = $this->person->spousalFamilies();
        $childFamilies = $this->person->childFamilies();

        $height = 3;

        $width = array_sum(
            $spousalFamilies->map(fn($family) => max(1, count($family->children())))
                ->toArray(),
        );

        $x = 1;

        foreach($spousalFamilies as $i => $family) {
            $objects[] = new Person(
                $this->person->id() === $family->husband()?->id()
                    ? $family->wife() : $family->husband(),
                y: 2,
                x: $x + floor(count($family->children()) / 2),
            );

            $parentEnd = $x + floor(count($family->children()) / 2) + 1;

            foreach($family->children() as $j => $child) {
                $objects[] = new Person($child, y: 3, x: $x++);

                if($j < count($family->children()) - 1) {
                    $objects[] = new HorizontalLine(y: 3, x: $x);
                }
            }

            $objects[] = new HorizontalLine(
                y: 2,
                x: $parentEnd ?: $x,
                xTo: $x + ($spousalFamilies->has($i + 1)
                    ? $spousalFamilies[$i + 1]?->children()->count() ?? 1 : 1),
            );
        }

        $objects[] = new Person($this->person, y: 2, x: $x++, highlight: true);

        foreach($childFamilies as $family) {
            if(count($family->children()) > 1) {
                $objects[] = new HorizontalLine(y: 2, x: $x);
            }

            $objects[] = new Person($family->husband(), y: 1, x: $x + floor(count($family->children()) / 2) - 1);
            $objects[] = new HorizontalLine(y: 1, x: $x + floor(count($family->children()) / 2));
            $objects[] = new Person($family->wife(), y: 1, x: $x + floor(count($family->children()) / 2));

            foreach($family->children()->filter(fn($child) => $child->id() !== $this->person->id()) as $child) {
                $objects[] = new HorizontalLine(y: 2, x: $x);
                $objects[] = new Person($child, y: 2, x: $x++);
            }
        }

        return '<div class="family">'.implode($objects).'</div>';
    }
}

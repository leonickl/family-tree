<?php

namespace App\Plot;

class Plot
{
    public int $width = 0;

    public function __construct(private \App\Models\Person $person) {}

    public function __toString()
    {
        $objects = [];

        $spousalFamilies = $this->person->spousalFamilies();
        $childFamilies = $this->person->childFamilies();

        $this->width = array_sum(
            $spousalFamilies->map(fn ($family) => max(1, count($family->children())))
                ->toArray(),
        );

        $x = 1;

        foreach ($spousalFamilies as $i => $family) {
            $objects[] = new Person(
                $this->person->id === $family->husband()?->id
                    ? $family->wife() : $family->husband(),
                y: 2,
                x: $parent = $x + floor(count($family->children()) / 2),
            );

            if (count($family->children()) > 0) {
                $objects[] = new VerticalLine(y: 2, x: $parent);
            }

            foreach ($family->children() as $j => $child) {
                $objects[] = new Person($child, y: 3, x: $x++);

                if ($j < count($family->children()) - 1) {
                    $objects[] = new SiblingLine(y: 3, x: $x);
                }
            }

            if (count($family->children()) === 0) {
                $x++;
            }

            $objects[] = new PartnerLine(
                y: 2,
                x: $parent + 1,
                xTo: $x + ($spousalFamilies->has($i + 1)
                    ? ($spousalFamilies[$i + 1]?->children()->count() ?? 1) + 1 : 1),
            );
        }

        $objects[] = new Person($this->person, y: 2, x: $x++, highlight: true);

        foreach ($childFamilies as $family) {
            if (count($family->children()) > 1) {
                $objects[] = new SiblingLine(y: 2, x: $x);
            }

            $objects[] = new Person($family->husband(), y: 1, x: $x + floor(count($family->children()) / 2) - 1);
            $objects[] = new PartnerLine(y: 1, x: $x + floor(count($family->children()) / 2));
            $objects[] = new VerticalLine(y: 1, x: $x + floor(count($family->children()) / 2) - 1);
            $objects[] = new Person($family->wife(), y: 1, x: $x + floor(count($family->children()) / 2));

            foreach ($family->children()->filter(fn ($child) => $child->id !== $this->person->id) as $child) {
                $objects[] = new SiblingLine(y: 2, x: $x);
                $objects[] = new Person($child, y: 2, x: $x++);
            }
        }

        return "<div class=\"family\">\n".implode("\n", $objects)."\n</div>";
    }
}

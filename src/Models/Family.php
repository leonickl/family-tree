<?php

namespace App\Models;

use PXP\Data\Model;
use PXP\Ds\Vector;

/**
 * @property int $id
 * @property ?int $husband_id
 * @property ?int $wife_id
 */
class Family extends Model
{
    protected string $table = 'families';

    public function name(): string
    {
        return v(
            $this->husband(),
            $this->wife(),
            ...$this->children(),
        )
            ->filter()
            ->sort(fn ($person) => $person->name())
            ->map(fn ($person) => "<a href=\"/tree/people/$person->id\">".$person->name().'</a>')
            ->join(', ');
    }

    public function husband(): ?Person
    {
        return Person::findOrNull($this->husband_id);
    }

    public function wife(): ?Person
    {
        return Person::findOrNull($this->wife_id);
    }

    public function children(): Vector
    {
        return ChildRelation::findAllBy('family_id', $this->id)
            ->map(fn ($relation) => $relation->child());
    }
}

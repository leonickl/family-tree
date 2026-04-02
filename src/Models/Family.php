<?php

namespace App\Models;

use PXP\Data\Model;
use PXP\Ds\Vector;

/**
 * @property int $id
 * @property ?string $identifier
 * @property ?string $husband_identifier
 * @property ?string $wife_identifier
 */
class Family extends Model
{
    protected string $table = 'families';

    public function id(): string
    {
        return $this->identifier;
    }

    public function name(): string
    {
        return v(
            $this->husband(),
            $this->wife(),
            ...$this->children(),
        )
            ->filter()
            ->sort(fn ($person) => $person->name())
            ->map(fn ($person) =>"<a href=\"/tree/people/$person->identifier\">".$person->name()."</a>")
            ->join(', ');
    }

    public function husband(): ?Person
    {
        return Person::findByOrNull('identifier', $this->husband_identifier);
    }

    public function wife(): ?Person
    {
        return Person::findByOrNull('identifier', $this->wife_identifier);
    }

    public function children(): Vector
    {
        return ChildRelation::findAllBy('family_identifier', $this->identifier)
            ->map(fn ($relation) => $relation->child());
    }
}

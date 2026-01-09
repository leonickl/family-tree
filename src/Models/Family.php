<?php

namespace App\Models;

use PXP\Core\Lib\Model;

/**
 * @property int $id
 * @property ?string $identifier
 * @property ?string $husband_identifier
 * @property ?string $wife_identifier
 */
class Family extends Model
{
    protected string $table = 'families';

    public function husband()
    {
        return Person::findByOrNull('identifier', $this->husband_identifier);
    }

    public function wife()
    {
        return Person::findByOrNull('identifier', $this->wife_identifier);
    }

    public function children()
    {
        return ChildRelation::findAllBy('family_identifier', $this->identifier)
            ->map(fn($relation) => $relation->child());
    }
}

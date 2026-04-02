<?php

namespace App\Models;

use PXP\Data\Model;
use PXP\Ds\Vector;

/**
 * @property int $id
 * @property ?string $identifier
 * @property ?string $name_prefix
 * @property ?string $name_first
 * @property ?string $name_last
 * @property ?string $name_marriage
 * @property ?string $name_suffix
 * @property ?string $gender
 * @property ?string $birth_date
 * @property ?string $birth_place
 * @property ?string $death
 * @property ?string $death_date
 * @property ?string $death_place
 * @property ?string $death_cause
 * @property ?string $buriage_date
 * @property ?string $buriage_place
 */
class Person extends Model
{
    protected string $table = 'people';

    public function id(): string
    {
        return $this->identifier;
    }

    public function name(): string
    {
        return v(
            $this->name_prefix,
            $this->name_first,
            $this->name_last,
            $this->name_marriage,
            $this->name_suffix,
        )
            ->filter(fn ($name) => $name !== null && trim($name) !== '')
            ->join(' ');
    }

    public function gender(): string
    {
        return match ($this->gender) {
            'M' => 'male',
            'F' => 'female',
            'U' => 'unknown',
            default => $this->gender,
        };
    }

    public function death(): bool
    {
        return $this->death === 'Y';
    }

    public function childFamilies(): Vector
    {
        return ChildRelation::findAllBy('child_identifier', $this->identifier)
            ->map(fn ($relation) => Family::findBy('identifier', $relation->family_identifier));
    }

    public function spousalFamilies(): Vector
    {
        return Family::findAllBy('husband_identifier', $this->identifier)
            ->with(...Family::findAllBy('wife_identifier', $this->identifier));
    }

    public function __toString(): string
    {
        if (trim($this->name()) === '') {
            return '---';
        }

        return $this->name();
    }
}

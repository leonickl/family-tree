<?php

namespace App\Models;

use PXP\Data\Model;
use PXP\Ds\Vector;

/**
 * @property int $id
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
        return ChildRelation::findAllBy('child_id', $this->id)
            ->map(fn ($relation) => Family::findBy('id', $relation->family_id));
    }

    public function spousalFamilies(): Vector
    {
        return Family::findAllBy('husband_id', $this->id)
            ->with(...Family::findAllBy('wife_id', $this->id));
    }

    public function families(): Vector
    {
        return $this->childFamilies()
            ->with(...$this->spousalFamilies());
    }

    public function __toString(): string
    {
        if (trim($this->name()) === '') {
            return '---';
        }

        return $this->name();
    }
}

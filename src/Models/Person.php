<?php

namespace App\Models;

use PXP\Core\Lib\Model;

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
}

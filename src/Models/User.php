<?php

namespace App\Models;

use PXP\Auth\Models\User as BaseUser;

/**
 * @property int $person_id
 */
class User extends BaseUser
{
    public function person(): ?Person
    {
        return Person::findOrNull($this->person_id);
    }
}

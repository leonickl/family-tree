<?php

namespace App\Models;

use PXP\Auth\Models\User as BaseUser;

/**
 * @property int $person_id
 */
class User extends BaseUser
{
    public function person(): Person
    {
        return Person::find($this->person_id);
    }
}

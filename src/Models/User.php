<?php

namespace App\Models;

use PXP\Data\Model;

/**
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property int $person_id
 */
class User extends Model
{
    protected string $table = 'users';

    public function setPasswordHash(string $password): void
    {
        $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
    }

    public function person(): Person
    {
        return Person::find($this->person_id);
    }
}

<?php

namespace App\Models;

use PXP\Core\Lib\Model;

/**
 * @property int $id
 * @property ?string $child_identifier
 * @property ?string $family_identifier
 */
class ChildRelation extends Model
{
    protected string $table = 'child_relations';

    public function child()
    {
        return Person::findBy('identifier', $this->child_identifier);
    }

    public function family()
    {
        return Family::findBy('identifier', $this->family_identifier);
    }
}

<?php

namespace App\Models;

use PXP\Data\Model;

/**
 * @property int $id
 * @property int $child_id
 * @property int $family_id
 */
class ChildRelation extends Model
{
    protected string $table = 'child_relations';

    public function child()
    {
        return Person::find($this->child_id);
    }

    public function family()
    {
        return Family::find($this->family_id);
    }
}

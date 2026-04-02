<?php

namespace App;

class Importer
{
    private array $tree;

    public function __construct(string $file)
    {
        $this->tree = json_decode(
            file_get_contents(path("database/$file.json")),
        );
    }

    public function people()
    {
        $attributes = [];
        $people = [];

        foreach ($this->tree as $entity) {
            if (@$entity->type === 'INDI') {
                $attributes = array_merge($attributes, $this->keys($entity));

                if ($entity->NAME->{'.'} !== trim(@$entity->NAME->GIVN.' '.@$entity->NAME->SURN)) {
                    exit("$entity->NAME has an illegal name attribute\n");
                }

                // TODO: implement "EDUC", "EVEN", "IMMI", "NOTE", "OCCU", "RESI"

                $people[] = \App\Models\Person::new(
                    id: trim($entity->id, '@'),
                    name_prefix: @$entity->NAME->PRFX,
                    name_first: @$entity->NAME->GIVN,
                    name_last: @$entity->NAME->SURN,
                    name_marriage: @$entity->NAME->_MARNM,
                    name_suffix: @$entity->NAME->NSFX,
                    gender: @$entity->SEX,
                    birth_date: @$entity->BIRT->DATE,
                    birth_place: @$entity->BIRT->PLAC,
                    death: @$entity->DEAT->{'.'},
                    death_date: @$entity->DEAT->DATE,
                    death_place: @$entity->DEAT->PLAC,
                    death_cause: @$entity->DEAT->CAUS,
                    buriage_date: @$entity->BURI->DATE,
                    buriage_place: @$entity->BURI->PLAC,
                );
            }
        }

        $attributes = array_unique($attributes);

        sort($attributes);

        $allowed_attributes = [
            'BIRT',
            'BIRT/DATE',
            'BIRT/PLAC',
            'BURI',
            'BURI/PLAC',
            'DEAT',
            'DEAT/.',
            'DEAT/AGE',
            'DEAT/CAUS',
            'DEAT/DATE',
            'DEAT/PLAC',
            'EDUC',
            'EVEN',
            'FAMC',
            'FAMS',
            'IMMI',
            'NAME',
            'NAME/.',
            'NAME/GIVN',
            'NAME/NPFX',
            'NAME/NSFX',
            'NAME/SURN',
            'NAME/_MARNM',
            'NOTE',
            'OCCU',
            'RESI',
            'RIN',
            'SEX',
            'SOUR',
            '_PROJECT_GUID',
            '_UID',
            '_UPD',
            'id',
            'type',
        ];

        $illegal_attributes = v(...$attributes)->without(...$allowed_attributes);

        if ($illegal_attributes->count() > 0) {
            exit('illegal attributes '.json_encode($illegal_attributes)."\n");
        }

        foreach ($people as $person) {
            $person->save();
        }
    }

    public function families()
    {
        $attributes = [];
        $families = [];
        $child_relationships = [];

        foreach ($this->tree as $entity) {
            if (@$entity->type === 'FAM') {
                $attributes = array_merge($attributes, $this->keys($entity));

                // TODO: implement "DIV", "EVEN", "MARR"

                $families[] = \App\Models\Family::new(
                    id: trim($entity->id, '@'),
                    husband_id: trim(@$entity->HUSB, '@'),
                    wife_id: trim(@$entity->WIFE, '@'),
                );

                foreach (@$entity->CHIL ?? [] as $child) {
                    $child_relationships[] = \App\Models\ChildRelation::new(
                        child_id: trim($child, '@'),
                        family_id: trim($entity->id, '@'),
                    );
                }
            }
        }

        $attributes = array_unique($attributes);

        sort($attributes);

        $allowed_attributes = [
            'CHIL',
            'DIV',
            'EVEN',
            'HUSB',
            'MARR',
            'RIN',
            'WIFE',
            '_UID',
            'id',
            'type',
        ];

        $illegal_attributes = v(...$attributes)->without(...$allowed_attributes);

        if ($illegal_attributes->count() > 0) {
            exit('illegal attributes '.json_encode($illegal_attributes)."\n");
        }

        foreach ($families as $family) {
            $family->save();
        }

        foreach ($child_relationships as $child_relationship) {
            $child_relationship->save();
        }
    }

    private function keys(object $object, string $prefix = '')
    {
        $keys = [];

        foreach ($object as $key => $value) {
            $keys[] = $prefix ? "$prefix/$key" : $key;

            if (is_object($value)) {
                $keys = array_merge($keys, $this->keys($value, $prefix ? "$prefix/$key" : $key));
            }
        }

        return $keys;
    }
}

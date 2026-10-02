<?php

namespace App;

enum Gender: string
{
    case MALE = 'M';
    case FEMALE = 'F';
    case DIVERSE = 'D';
    case UNKNOWN = 'U';

    public static function make(?string $gender): self
    {
        if ($gender === null) {
            return self::UNKNOWN;
        }

        return self::from($gender);
    }

    public static function all(): array
    {
        $genders = [];

        foreach (self::cases() as $gender) {
            $genders[$gender->value] = $gender->label();
        }

        return $genders;
    }

    public function label(): string
    {
        return match ($this) {
            self::MALE => 'male',
            self::FEMALE => 'female',
            self::DIVERSE => 'diverse',
            self::UNKNOWN => 'unknown',
        };
    }
}
<?php

declare(strict_types=1);

namespace SubStalker\VK\Enums;

use SubStalker\VK\Exceptions\UnknownSexException;

enum UserSex: int {
    case FEMALE = 1;
    case MALE = 2;

    /**
     * @throws UnknownSexException
     */
    public static function find(int $value): UserSex
    {
        foreach (UserSex::cases() as $sex) {
            if ($value === $sex->value) {
                return $sex;
            }
        }

        throw new UnknownSexException("$value - is not a valid value for enum " . self::class);
    }
}
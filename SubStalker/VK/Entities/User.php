<?php

declare(strict_types=1);

namespace SubStalker\VK\Entities;

use SubStalker\VK\Enums\UserSex;

class User extends Owner {

    private UserSex $sex;

    public function __construct(int $id, string $name, UserSex $sex) {
        parent::__construct($id, $name);

        $this->sex = $sex;
    }

    /**
     * @return UserSex
     */
    public function getSex(): UserSex
    {
        return $this->sex;
    }

    public function isFemale(): bool
    {
        return $this->sex === UserSex::FEMALE;
    }
}
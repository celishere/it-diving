<?php

declare(strict_types=1);

namespace SubStalker\VK\Entities;

class Group extends Owner {

    public function __construct(int $id, string $name) {
        parent::__construct($id, $name);
    }
}
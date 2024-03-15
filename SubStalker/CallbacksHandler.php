<?php

declare(strict_types=1);

namespace SubStalker;

use SubStalker\VK\VKClient;

use VK\CallbackApi\VKCallbackApiHandler;

class CallbacksHandler extends VKCallbackApiHandler {

    private Notifier $notifier;

    public function __construct(VKClient $client) {
        $this->notifier = new Notifier($client);
    }

    public function groupJoin(int $group_id, ?string $secret, array $object): void {
        $this->notifier->notifyJoin($object['user_id'], $group_id);
    }

    public function groupLeave(int $group_id, ?string $secret, array $object): void {
        $this->notifier->notifyLeave($object['user_id'], $group_id);
    }
}
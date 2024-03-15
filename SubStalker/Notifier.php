<?php

declare(strict_types=1);

namespace SubStalker;

use SubStalker\VK\Entities\Group;
use SubStalker\VK\Entities\Owner;
use SubStalker\VK\Entities\User;

use SubStalker\VK\VKClient;

class Notifier {

    private VKClient $client;

    const NOTIFICATION_TYPE_JOIN = "join";
    const NOTIFICATION_TYPE_LEAVE = "leave";

    public function __construct(VKClient $client) {
        $this->client = $client;
    }

    public function notifyJoin(int $user_id, int $group_id): void {
        $this->notify(self::NOTIFICATION_TYPE_JOIN, $user_id, $group_id);
    }

    public function notifyLeave(int $user_id, int $group_id): void {
        $this->notify(self::NOTIFICATION_TYPE_LEAVE, $user_id, $group_id);
    }

    private function notify(string $type, int $user_id, int $group_id): void {
        $user = $this->client->getUser($user_id);
        if (!$user) {
            echo "failed to load user {$user_id}\n";
            return;
        }

        $group = $this->client->getGroup($group_id);
        if (!$group) {
            echo "failed to load group {$group_id}\n";
            return;
        }

        $text = self::buildText($type, $user, $group);

        $this->client->sendMessage(Config::$RECEIVER_ID, $text);
    }

    private static function buildMention(Owner $owner): string {
        $prefix = ($owner instanceof Group) ? 'club' : 'id';

        return "[{$prefix}{$owner->getId()}|{$owner->getName()}]";
    }

    private function buildText(string $type, User $user, Group $group): string {
        $user_mention = self::buildMention($user);
        $group_mention = self::buildMention($group);

        switch ($type) {
            case self::NOTIFICATION_TYPE_JOIN:
                $action = $user->isFemale() ? "подписалась" : "подписался";

                return "{$user_mention} {$action} на сообщество {$group_mention} =)";
            case self::NOTIFICATION_TYPE_LEAVE:
                $action = $user->isFemale() ? "отписалась" : "отписался";

                return "{$user_mention} {$action} на сообщество {$group_mention} =(";
            default:
                return "Unknown event: {$type}";
        }
    }
}
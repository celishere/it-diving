<?php

declare(strict_types=1);

namespace SubStalker\VK;

use SubStalker\Config;

use SubStalker\VK\Entities\Group;
use SubStalker\VK\Entities\User;

use SubStalker\VK\Enums\UserSex;

use VK\Client\VKApiClient;

class VKClient {

    private VKApiClient $client;

    public function __construct(VKApiClient $client) {
        $this->client = $client;
    }

    public function getUser(int $user_id): ?User {
        try {
            $response = $this->client->users()->get(Config::$ACCESS_TOKEN, [
                'user_ids' => [$user_id],
                'fields' => ['sex']
            ])[0];

            $sex = UserSex::find($response['sex']);
        } catch (\Exception $e) {
            var_dump($e);
            return null;
        }

        return new User(
            $user_id,
            $response['first_name'] . ' ' . $response['last_name'],
            $sex
        );
    }

    public function getGroup(int $group_id): ?Group {
        try {
            $response = $this->client->groups()->getById(Config::$ACCESS_TOKEN, [
                'group_id' => $group_id
            ])['groups'][0];
        } catch (\Exception $e) {
            var_dump($e);
            return null;
        }

        return new Group(
            $group_id,
            $response['name']
        );
    }

    public function sendMessage(int $to_id, string $text): void {
        try {
            $this->client->messages()->send(Config::$ACCESS_TOKEN, [
                'peer_id' => $to_id,
                'message' => $text,
                'random_id' => rand()
            ]);
        } catch (\Exception $e) {
            var_dump($e);
        }
    }
}
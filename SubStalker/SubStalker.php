<?php

namespace SubStalker;

use Generator\Skeleton\skeleton\base\src\VK\CallbackApi\VKCallbackApiLongPollExecutor;
use VK\Client\VKApiClient;

use SubStalker\VK\VKClient;

class SubStalker {
  private CallbacksHandler $handler;
  private VKCallbackApiLongPollExecutor $executor;

  public function __construct(int $group_id, string $access_token) {
    $client = new VKApiClient('5.199');

    $this->handler = new CallbacksHandler(new VKClient($client));
    $this->executor = new VKCallbackApiLongPollExecutor(
      $client,
      $access_token,
      $group_id,
      $this->handler
    );
  }

  public function listen(): void {
    $ts = time();

    while (true) {
      try {
        $ts = $this->executor->listen($ts);
      } catch (\Exception) {
      }
    }
  }
}

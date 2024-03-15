<?php

use Dotenv\Dotenv;

use SubStalker\SubStalker;
use SubStalker\Config;

require_once 'vendor/autoload.php';

main();

function main(): void {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    Config::buildConfig($_ENV['GROUP_ID'], $_ENV['ACCESS_TOKEN'], $_ENV['RECEIVER_ID']);

    $app = new SubStalker(Config::$GROUP_ID, Config::$ACCESS_TOKEN);
    $app->listen();
}

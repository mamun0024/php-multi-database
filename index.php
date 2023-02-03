<?php

use App\Application;

require 'vendor/autoload.php';

$dotEnv = Dotenv\Dotenv::createMutable(__DIR__);
$dotEnv->load();

$app = new Application();

$app->run();

<?php

use App\Application;

require 'vendor/autoload.php';

const DOCUMENT_ROOT = __DIR__;

$dotEnv = Dotenv\Dotenv::createMutable(DOCUMENT_ROOT);
$dotEnv->load();

$app = new Application();

$app->run();

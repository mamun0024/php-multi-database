<?php

use App\Application;

require 'vendor/autoload.php';

const DOCUMENT_ROOT = __DIR__;

$dotEnv = Dotenv\Dotenv::createMutable(DOCUMENT_ROOT);
$dotEnv->load();

$config = require DOCUMENT_ROOT . '/app/config.php';

$app = new Application($config);

echo "<pre>";
print_r($app->run());
echo "</pre>";

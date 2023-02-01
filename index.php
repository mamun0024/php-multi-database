<?php

require_once 'vendor/autoload.php';

use App\Application;

$dot_env = Dotenv\Dotenv::createMutable(__DIR__);
$dot_env->load();

$app = new Application([
    'settings' => [
        'db' => [
            'driver'   => $_ENV['DB_DRIVER'],
            'host'     => $_ENV['DB_HOST'],
            'port'     => $_ENV['DB_PORT'],
            'database' => $_ENV['DB_DATABASE'],
            'user'     => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
        ],
    ],
]);

echo "<pre>";
print_r($app->run());
echo "</pre>";

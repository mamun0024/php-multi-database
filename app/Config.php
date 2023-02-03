<?php

namespace App;

/**
 * Class Config
 */
class Config
{
    private static ?Config $instance = null;

    /**
     * @var array<string, array<string, array<string, mixed>>>
     */
    private array $config;

    private function __construct()
    {
        $this->config = [
            'settings' => [
                'db'  => [
                    'driver'   => $_ENV['DB_DRIVER'],
                    'host'     => $_ENV['DB_HOST'],
                    'port'     => $_ENV['DB_PORT'],
                    'database' => $_ENV['DB_DATABASE'],
                    'user'     => $_ENV['DB_USER'],
                    'password' => $_ENV['DB_PASSWORD'],
                ],
                'log' => [
                    'path' => $_ENV['LOG_PATH'],
                ],
            ],
        ];
    }

    /**
     * @return Config
     */
    private static function getInstance(): Config
    {
        if (!self::$instance) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    /**
     * @return array<string, array<string, array<string, mixed>>>
     */
    public static function getConfig(): array
    {
        return self::getInstance()->config;
    }
}

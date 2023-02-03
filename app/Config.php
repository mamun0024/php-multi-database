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
        $this->config = require DOCUMENT_ROOT . '/app/configurations.php';
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

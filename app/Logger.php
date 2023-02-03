<?php

namespace App;

/**
 * Class Logger
 */
class Logger
{
    public const INFO  = 'info';
    public const ERROR = 'error';

    private static ?Logger $instance = null;

    /**
     * @var array<string, array<string, array<string, mixed>>>
     */
    private $config;

    private function __construct()
    {
        $this->config = Config::getConfig();
    }

    /**
     * @return Logger
     */
    private static function getInstance(): Logger
    {
        if (!self::$instance) {
            self::$instance = new Logger();
        }

        return self::$instance;
    }

    /**
     * @param string $message
     *
     * @return void
     */
    private function writeToFile(string $message): void
    {
        $file = fopen($this->config['settings']['log']['path'], 'a+') or die("Unable to open file!");

        fwrite($file, $message);

        fclose($file);
    }

    /**
     * @param string $message
     * @param string $type
     *
     * @return void
     */
    public static function log(string $message, string $type = self::INFO): void
    {
        self::getInstance()->writeToFile("[" . date('Y-m-d H:i:s') . "] [$type] :: $message \n" . PHP_EOL);
    }
}

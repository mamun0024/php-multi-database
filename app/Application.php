<?php

namespace App;

class Application
{
    /**
     * @var array<string, mixed>
     */
    private array $databaseSettings;

    /**
     * @param array<string, array<string, array<string, mixed>>> $settings
     */
    public function __construct(array $settings = [])
    {
        $this->databaseSettings = $settings['settings']['db'];
    }

    /**
     * Run the app.
     *
     * @return array<string, mixed>
     */
    public function run(): array
    {
        return $this->databaseSettings;
    }
}

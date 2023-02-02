<?php

namespace App;

use App\Database\Database;
use PDO;

class Application
{
    /**
     * @var Database
     */
    private Database $database;

    /**
     * @param array<string, array<string, array<string, mixed>>> $config
     */
    public function __construct(array $config = [])
    {
        $this->database = new Database($config['settings']['db']);
    }

    /**
     * @return PDO
     */
    public function run(): PDO
    {
        return $this->database->getConnection();
    }
}

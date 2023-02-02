<?php

namespace App\Database;

use App\Logger;
use PDO;
use PDOException;

/**
 * Class Database
 */
class Database
{
    /**
     * @var PDO
     */
    private PDO $connection;

    /**
     * @param array<string> $databaseConfig
     */
    public function __construct(array $databaseConfig)
    {
        $driver   = $databaseConfig['driver'] ?? '';
        $host     = $databaseConfig['host'] ?? '';
        $port     = $databaseConfig['port'] ?? '';
        $database = $databaseConfig['database'] ?? '';
        $user     = $databaseConfig['user'] ?? '';
        $password = $databaseConfig['password'] ?? '';

        try {
            $this->connection = new PDO(
                $driver . ':host=' . $host . ';port=' . $port . ';dbname=' . $database,
                $user,
                $password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            Logger::log("Failed to connect to DB: " . $e->getMessage(), Logger::ERROR);
            exit();
        }
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}

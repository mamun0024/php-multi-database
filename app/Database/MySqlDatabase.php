<?php

namespace App\Database;

use App\Contracts\DatabaseConnectionInterface;
use App\Logger;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Class MySqlDatabase
 */
class MySqlDatabase implements DatabaseConnectionInterface
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
            Logger::log($e, Logger::ERROR);
            exit();
        }
    }

    /**
     * @param string                      $query
     * @param array<array<string, mixed>> $data
     *
     * @return PDOStatement
     */
    public function prepareStatement(string $query, array $data = []): PDOStatement
    {
        $statement = $this->getConnection()->prepare($query);
        foreach ($data as $item) {
            $statement->bindParam(':' . $item['field'], $item['value']);
        }

        return $statement;
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}

<?php

namespace App\Contracts;

use PDO;
use PDOStatement;

interface DatabaseConnectionInterface
{
    /**
     * @param string                      $query
     * @param array<array<string, mixed>> $data
     *
     * @return PDOStatement
     */
    public function prepareStatement(string $query, array $data): PDOStatement;

    /**
     * @return PDO
     */
    public function getConnection(): PDO;
}

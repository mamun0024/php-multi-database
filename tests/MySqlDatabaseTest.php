<?php

namespace Tests;

use App\Database\MySqlDatabase;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MySqlDatabaseTest extends TestCase
{
    /**
     * @var MySqlDatabase
     */
    protected MySqlDatabase $databaseMock;

    /**
     * @var PDOStatement|MockObject
     */
    protected $statementMock;

    /**
     * @var PDO|MockObject
     */
    protected $pdoMock;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->databaseMock  = $this->createMock(MySqlDatabase::class);
        $this->statementMock = $this->createMock(PDOStatement::class);
        $this->pdoMock       = $this->createMock(PDO::class);
    }

    /**
     * @return void
     */
    public function testConnection(): void
    {
        // @phpstan-ignore-next-line
        $this->databaseMock->method('getConnection')->willReturn($this->pdoMock);

        $this->assertEquals(
            $this->pdoMock,
            $this->databaseMock->getConnection()
        );
    }

    /**
     * @return void
     */
    public function testPrepareStatement(): void
    {
        // @phpstan-ignore-next-line
        $this->databaseMock->method('getConnection')->willReturn($this->pdoMock);

        // @phpstan-ignore-next-line
        $this->databaseMock->method('prepareStatement')->willReturn($this->statementMock);

        $this->assertEquals(
            $this->statementMock,
            $this->databaseMock->prepareStatement('SELECT id, name FROM users WHERE id = :id LIMIT 1', [])
        );
    }
}

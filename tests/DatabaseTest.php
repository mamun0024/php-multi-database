<?php

namespace Tests;

use App\Database\Database;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    /**
     * @var Database
     */
    protected Database $databaseMock;

    /**
     * @var PDOStatement|MockObject
     */
    protected $statementMock;

    /**
     * @var PDO|MockObject
     */
    protected $pdoMock;

    protected function setUp(): void
    {
        $this->databaseMock  = $this->createMock(Database::class);
        $this->statementMock = $this->createMock(PDOStatement::class);
        $this->pdoMock       = $this->createMock(PDO::class);
    }

    public function testConnection(): void
    {
        // @phpstan-ignore-next-line
        $this->databaseMock->method('getConnection')->willReturn($this->pdoMock);

        $this->assertEquals(
            $this->pdoMock,
            $this->databaseMock->getConnection()
        );
    }

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

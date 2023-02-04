<?php

namespace Tests;

use App\Database\MySqlDatabase;
use App\Database\MySqlQueryBuilder;
use App\Exceptions\SqlQueryBuilderException;
use PHPUnit\Framework\TestCase;

class MySqlQueryBuilderTest extends TestCase
{
    use MockTrait;

    /**
     * @var MySqlQueryBuilder
     */
    private MySqlQueryBuilder $queryBuilder;

    /**
     * @var MySqlDatabase
     */
    protected MySqlDatabase $databaseMock;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->databaseMock = $this->createMock(MySqlDatabase::class);
        $this->queryBuilder = new MySqlQueryBuilder($this->databaseMock);
    }

    /**
     * @return void
     */
    public function testSelectErrorCheck(): void
    {
        try {
            $this->queryBuilder->select('users', []);
        } catch (SqlQueryBuilderException $e) {
            $this->assertStringContainsString(
                'Columns selection is mandatory for SELECT',
                $e->getMessage()
            );
        }
    }

    /**
     * @return void
     */
    public function testWhereErrorCheck(): void
    {
        try {
            $this->queryBuilder->where('id', '68c68470-f25f-4ce4-bbf4-05f50bd82fc4');
        } catch (SqlQueryBuilderException $e) {
            $this->assertStringContainsString(
                'WHERE can only be added to SELECT, UPDATE OR DELETE',
                $e->getMessage()
            );
        }
    }

    /**
     * @return void
     */
    public function testInsertErrorCheck(): void
    {
        try {
            $this->queryBuilder->insert('users', []);
        } catch (SqlQueryBuilderException $e) {
            $this->assertStringContainsString(
                'DATA is mandatory for INSERT',
                $e->getMessage()
            );
        }
    }

    /**
     * @return void
     */
    public function testFindOneErrorCheck(): void
    {
        try {
            $this->queryBuilder->findOne();
        } catch (SqlQueryBuilderException $e) {
            $this->assertStringContainsString(
                'findOne() can only be used after SELECT',
                $e->getMessage()
            );
        }
    }

    /**
     * @return void
     */
    public function testGetErrorCheck(): void
    {
        try {
            $this->queryBuilder->get();
        } catch (SqlQueryBuilderException $e) {
            $this->assertStringContainsString(
                'get() can only be used after SELECT',
                $e->getMessage()
            );
        }
    }

    /**
     * @return void
     * @throws SqlQueryBuilderException
     */
    public function testInsertData(): void
    {
        $queryBuilderMock = $this->createMock(MySqlQueryBuilder::class);

        $this->setMock($queryBuilderMock, 'insert', true);

        $result = $queryBuilderMock->insert(
            'users',
            [
                'id'   => '68c68470-f25f-4ce4-bbf4-05f50bd82fc4',
                'name' => 'Johny Bravo',
            ]
        );

        $this->assertEquals(true, $result);
    }

    /**
     * @return void
     * @throws SqlQueryBuilderException
     */
    public function testFindOneDataFetch(): void
    {
        $data = [
            'id'   => '68c68470-f25f-4ce4-bbf4-05f50bd82fc4',
            'name' => 'Johny Bravo',
        ];

        $queryBuilderMock = $this->createMock(MySqlQueryBuilder::class);

        $this->setMock($queryBuilderMock, 'select', $queryBuilderMock);
        $this->setMock($queryBuilderMock, 'findOne', $data);

        $result = $queryBuilderMock->select('users', ['id', 'name'])->findOne();

        $this->assertEquals($data, $result);
    }

    /**
     * @return void
     * @throws SqlQueryBuilderException
     */
    public function testGetDataFetch(): void
    {
        $data = [
            [
                'id'   => '8a8e519b-8768-48d9-90c0-81569d3ded9b',
                'name' => 'Matt Damon',
            ],
            [
                'id'   => '68c68470-f25f-4ce4-bbf4-05f50bd82fc4',
                'name' => 'Johny Bravo',
            ]
        ];

        $queryBuilderMock = $this->createMock(MySqlQueryBuilder::class);

        $this->setMock($queryBuilderMock, 'select', $queryBuilderMock);
        $this->setMock($queryBuilderMock, 'get', $data);

        $result = $queryBuilderMock->select('users', ['id', 'name'])->get();

        $this->assertEquals($data, $result);
    }
}

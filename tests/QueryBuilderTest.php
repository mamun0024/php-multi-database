<?php

namespace Tests;

use App\Database\Database;
use App\Database\QueryBuilder;
use App\Exceptions\SqlQueryBuilderException;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    use MockTrait;

    /**
     * @var QueryBuilder
     */
    private QueryBuilder $queryBuilder;

    /**
     * @var Database
     */
    protected Database $databaseMock;

    protected function setUp(): void
    {
        $this->databaseMock = $this->createMock(Database::class);
        $this->queryBuilder = new QueryBuilder($this->databaseMock);
    }

    public function testSelectErrorCheck(): void
    {
        try {
            $this->queryBuilder->select('users', []);
        } catch (SqlQueryBuilderException $e) {
            $this->assertStringContainsString(
                'Exception : Error',
                $e->errorMessage()
            );
        }
    }

    public function testWhereErrorCheck(): void
    {
        try {
            $this->queryBuilder->where('id', '68c68470-f25f-4ce4-bbf4-05f50bd82fc4');
        } catch (SqlQueryBuilderException $e) {
            $this->assertStringContainsString(
                'Exception : Error',
                $e->errorMessage()
            );
        }
    }

    public function testInsertErrorCheck(): void
    {
        try {
            $this->queryBuilder->insert('users', []);
        } catch (SqlQueryBuilderException $e) {
            $this->assertStringContainsString(
                'Exception : Error',
                $e->errorMessage()
            );
        }
    }

    public function testFindOneErrorCheck(): void
    {
        try {
            $this->queryBuilder->findOne();
        } catch (SqlQueryBuilderException $e) {
            $this->assertStringContainsString(
                'Exception : Error',
                $e->errorMessage()
            );
        }
    }

    public function testGetErrorCheck(): void
    {
        try {
            $this->queryBuilder->get();
        } catch (SqlQueryBuilderException $e) {
            $this->assertStringContainsString(
                'Exception : Error',
                $e->errorMessage()
            );
        }
    }

    public function testInsertData(): void
    {
        $queryBuilderMock = $this->createMock(QueryBuilder::class);

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

    public function testFindOneDataFetch(): void
    {
        $data = [
            'id'   => '68c68470-f25f-4ce4-bbf4-05f50bd82fc4',
            'name' => 'Johny Bravo',
        ];

        $queryBuilderMock = $this->createMock(QueryBuilder::class);

        $this->setMock($queryBuilderMock, 'select', $queryBuilderMock);
        $this->setMock($queryBuilderMock, 'findOne', $data);

        $result = $queryBuilderMock->select('users', ['id', 'name'])->findOne();

        $this->assertEquals($data, $result);
    }

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

        $queryBuilderMock = $this->createMock(QueryBuilder::class);

        $this->setMock($queryBuilderMock, 'select', $queryBuilderMock);
        $this->setMock($queryBuilderMock, 'get', $data);

        $result = $queryBuilderMock->select('users', ['id', 'name'])->get();

        $this->assertEquals($data, $result);
    }
}

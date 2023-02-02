<?php

namespace App;

use App\Contracts\SqlQueryBuilderInterface;
use App\Database\Database;
use App\Database\QueryBuilder;

class Application
{
    /**
     * @var array<string, array<string, array<string, mixed>>>
     */
    private array $config;

    /**
     * @param array<string, array<string, array<string, mixed>>> $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param SqlQueryBuilderInterface $sqlQueryBuilder
     *
     * @return SqlQueryBuilderInterface
     */
    private function getSqlQueryBuilder(SqlQueryBuilderInterface $sqlQueryBuilder): SqlQueryBuilderInterface
    {
        return $sqlQueryBuilder;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $queryBuilder = $this->getSqlQueryBuilder(new QueryBuilder(new Database($this->config['settings']['db'])));

        $queryBuilder->insert(
            'users',
            [
                'id'   => '8a8e519b-8768-48d9-90c0-81569d3ded9b',
                'name' => 'Matt Damon',
            ]
        );

        $queryBuilder->insert(
            'users',
            [
                'id'   => '68c68470-f25f-4ce4-bbf4-05f50bd82fc4',
                'name' => 'Johny Bravo',
            ]
        );

        $queryBuilder->insert(
            'users',
            [
                'id'   => '60bb0ca5-25d1-43bd-98e5-6a878c00a0d8',
                'name' => 'Rafael Nadal',
            ]
        );

        echo "<pre>";
        print_r(
            $queryBuilder->select('users', ['id', 'name'])
                         ->where('id', '68c68470-f25f-4ce4-bbf4-05f50bd82fc4')
                         ->findOne()
        );
        echo "</pre>";
    }
}

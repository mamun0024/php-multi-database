<?php

namespace App\Database;

use App\Contracts\DatabaseConnectionInterface;
use App\Contracts\SqlQueryBuilderInterface;
use App\Exceptions\SqlQueryBuilderException;
use PDO;
use stdClass;

/**
 * Class QueryBuilder
 */
class QueryBuilder implements SqlQueryBuilderInterface
{
    /**
     * @var DatabaseConnectionInterface
     */
    protected DatabaseConnectionInterface $databaseConnector;

    /**
     * @var stdClass
     */
    protected stdClass $query;

    /**
     * @param DatabaseConnectionInterface $databaseConnector
     */
    public function __construct(DatabaseConnectionInterface $databaseConnector)
    {
        $this->databaseConnector = $databaseConnector;
    }

    protected function newQuery(): void
    {
        $this->query = new stdClass();
    }

    /**
     * @param string             $table
     * @param array<int, string> $columns
     *
     * @return SqlQueryBuilderInterface
     * @throws SqlQueryBuilderException
     */
    public function select(string $table, array $columns): SqlQueryBuilderInterface
    {
        if (empty($columns)) {
            throw new SqlQueryBuilderException("Columns selection is mandatory for SELECT");
        }

        $this->newQuery();
        $this->query->string = "SELECT " . implode(", ", $columns) . " FROM " . $table;
        $this->query->type   = 'select';

        return $this;
    }

    /**
     * @param string $field
     * @param string $value
     * @param string $operator
     *
     * @return SqlQueryBuilderInterface
     * @throws SqlQueryBuilderException
     */
    public function where(string $field, string $value, string $operator = '='): SqlQueryBuilderInterface
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new SqlQueryBuilderException("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }

        $this->query->where[] = [
            'field'    => $field,
            'operator' => $operator,
            'value'    => $value
        ];

        return $this;
    }

    /**
     * @param string               $table
     * @param array<string, mixed> $data
     *
     * @return bool
     * @throws SqlQueryBuilderException
     */
    public function insert(string $table, array $data): bool
    {
        if (empty($data)) {
            throw new SqlQueryBuilderException("DATA is mandatory for INSERT");
        }

        $this->newQuery();
        $dataColumns = array_keys($data);
        $insertQuery = "INSERT INTO $table (" . implode(", ", $dataColumns) . ")
                        VALUES (" . implode(", ", array_map(fn($attr) => ":$attr", $dataColumns)) . ")";

        $insertData = [];
        foreach ($data as $key => $value) {
            $insertData[] = [
                'field' => $key,
                'value' => $value
            ];
        }

        $statement = $this->databaseConnector->prepareStatement($insertQuery, $insertData);

        return $statement->execute();
    }

    /**
     * @return mixed
     * @throws SqlQueryBuilderException
     */
    public function findOne()
    {
        if (!isset($this->query->type)) {
            throw new SqlQueryBuilderException("findOne() can only be used after SELECT");
        }

        if (!in_array($this->query->type, ['select'])) {
            throw new SqlQueryBuilderException("findOne() can only be added to SELECT");
        }

        $sqlQuery = $this->prepareWhereSql($this->query->string, $this->query->where ?? []) . ' LIMIT 1';

        $statement = $this->databaseConnector->prepareStatement($sqlQuery, $this->query->where ?? []);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);

        return $statement->fetch();
    }

    /**
     * @return mixed
     * @throws SqlQueryBuilderException
     */
    public function get()
    {
        if (!isset($this->query->type)) {
            throw new SqlQueryBuilderException("get() can only be used after SELECT");
        }

        if (!in_array($this->query->type, ['select'])) {
            throw new SqlQueryBuilderException("get() can only be added to SELECT");
        }

        $sqlQuery = $this->prepareWhereSql($this->query->string, $this->query->where ?? []);

        $statement = $this->databaseConnector->prepareStatement($sqlQuery, $this->query->where ?? []);
        $statement->execute();
        $statement->setFetchMode(PDO::FETCH_ASSOC);

        return $statement->fetchAll();
    }

    /**
     * @param string                      $query
     * @param array<array<string, mixed>> $where
     *
     * @return string
     */
    protected function prepareWhereSql(string $query, array $where = []): string
    {
        if (!empty($where)) {
            $query      .= ' WHERE ';
            $conditions = [];
            foreach ($this->query->where as $key) {
                $conditions[] = $key['field'] . ' ' . $key['operator'] . ' :' . $key['field'];
            }
            $query .= implode(" AND ", $conditions);
        }

        return $query;
    }
}

<?php

namespace App\Contracts;

interface SqlQueryBuilderInterface
{
    /**
     * @param string             $table
     * @param array<int, string> $columns
     *
     * @return SqlQueryBuilderInterface
     */
    public function select(string $table, array $columns): SqlQueryBuilderInterface;

    /**
     * @param string $field
     * @param string $value
     * @param string $operator
     *
     * @return SqlQueryBuilderInterface
     */
    public function where(string $field, string $value, string $operator = '='): SqlQueryBuilderInterface;

    /**
     * @param string               $table
     * @param array<string, mixed> $data
     *
     * @return bool
     */
    public function insert(string $table, array $data): bool;

    /**
     * @return mixed
     */
    public function findOne();

    /**
     * @return mixed
     */
    public function get();
}

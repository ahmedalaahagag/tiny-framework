<?php

namespace App\Core\Database;

use PDO;

/**
 * Class QueryBuilder
 * @package App\Core\Database
 */
class QueryBuilder
{
    protected $connection;

    protected $model;

    protected $table;

    /**
     * QueryBuilder constructor.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * a function that sets the table/model that will be operated on
     * @param $model
     * @return $this
     */
    public function on($model)
    {
        $this->model = $model;

        $this->setTable();

        return $this;
    }

    /**
     * set table wrapper
     */
    protected function setTable()
    {
        $this->table = (new $this->model)->table;
    }

    /**
     * select * query
     * @return array
     */
    public function selectAll()
    {
        $sql = "select * from {$this->table}";

        return $this->execute($sql)->fetchAll(PDO::FETCH_CLASS, $this->model);
    }

    /**
     * prepare and exe query
     * @param $sql
     * @param array $parameters
     * @return \PDOStatement
     */
    protected function execute($sql, $parameters = [])
    {
        try {
            $query = $this->connection->prepare($sql);
            $query->execute($parameters);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        return $query;
    }

    /**
     * @param $parameters
     * @return \PDOStatement
     */
    public function insert($parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $this->table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );
        return $this->execute($sql, $parameters);
    }

    /**
     * @param $parameters
     * @param $where
     * @return \PDOStatement
     */
    public function update($parameters, $where)
    {
        $sql = sprintf(
            'update `%s` set %s where %s',
            $this->table,
            $this->prepareParameters($parameters),
            $this->prepareParameters($where)
        );
        return $this->execute($sql, array_merge($parameters, $where));
    }

    /**
     * update query preparing parameters for query injection
     * @param $parameters
     * @return string
     */
    protected function prepareParameters($parameters)
    {
        if (getCaller() == 'update' || (getCaller() == 'select' && count($parameters) == 1)) {
            return implode(', ', array_map(
                function ($k) {
                    return $k . '=:' . $k;
                },
                array_keys($parameters)));
        } else {
            return implode(' and ', array_map(
                function ($k) {
                    return $k . '=:' . $k;
                },
                array_keys($parameters)));
        }
    }

    /**
     * @param $where
     * @return array
     */
    public function select($where)
    {
        $sql = sprintf(
            'select * from %s where %s',
            $this->table,
            $this->prepareParameters($where)
        );
        return $this->execute($sql, $where)->fetch();
    }

    /**
     * delete with id
     */
    public function delete($where)
    {
        $sql = sprintf(
            'delete from %s where %s',
            $this->table,
            $this->prepareParameters($where)
        );
        return $this->execute($sql, $where);
    }

    /**
     * select with id
     * @return array with one record
     */
    public function get($id)
    {
        $sql = $this->connection->prepare("select * from {$this->table} where id={$id}");
        return $this->execute($sql)->fetchAll(PDO::FETCH_CLASS, $this->model);
    }


}

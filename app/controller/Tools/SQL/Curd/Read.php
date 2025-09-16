<?php

/*
|-----------------------------
|       CURD ( Read )
|-----------------------------
|
|
*/

namespace TOOL\SQL\Curd;


use TOOL\SQL\SQL;

final class Read
{

    /**
     * Options
     * 
     * @var object
     */
    private object $options;

    /**
     * Conditions
     * 
     * @var string
     */
    private string $conditions;

    /**
     * Columns
     * 
     * @var string
     */
    private string $columns = '*';

    /**
     * Statement
     * 
     * @var ?SQL
     */
    private ?SQL $statemet = null;


    /**
     * Read __construct
     * 
     * @param array $options
     */
    function __construct(array $options)
    {
        $this->options = (object) $options;
    }

    /**
     * Set conditions method
     * 
     * @param string $conditions
     */
    function setConditions(string $conditions)
    {
        $this->conditions = $conditions;
    }

    /**
     * Select method
     * 
     * @param string $columns
     * 
     * @return self
     */
    function select(string $columns)
    {

        // Remove "SELECT" if exists in first columns
        $this->columns = ltrim($columns, "SELECT");

        return $this;
    }

    /**
     * Prepare method
     * 
     */
    function prepare()
    {

        // Check access
        if (!$this->options->ACCESS_READ) return;

        // Query
        $Query = "SELECT {$this->columns} FROM {$this->options->table} WHERE {$this->conditions}";

        // Set statement
        $this->statemet = SQL::set($Query);
    }

    /**
     * Get method
     * 
     * @param array $params
     * 
     * @param int $fetch
     * 
     * @return
     */
    function get(array $params = [], int $fetch = SQL::FETCH)
    {
        return $this->statemet->exec($params, $fetch);
    }

    /**
     * Get all method
     * 
     * @param array $params
     * 
     * @return
     */
    function getAll(array $params = [])
    {
        return $this->get($params, SQL::FETCH_ALL);
    }

    /**
     * Read method
     * 
     * @param array $params
     * 
     * @param int $all
     * 
     * @return
     */
    function read(array $params = [], int $fetch = SQL::FETCH)
    {

        // Check access
        if (!$this->options->ACCESS_READ) return;

        // Columns
        $columns = $this->options->columns ?? $this->columns;

        // Query
        $Query = "SELECT {$columns} FROM {$this->options->table} WHERE {$this->conditions}";

        // Exec SQL
        return SQL::set($Query)->exec($params, $fetch);
    }

    /**
     * Read all method
     * 
     * @param array $params
     * 
     * @return
     */
    function readAll(array $params = [])
    {
        return $this->read($params, SQL::FETCH_ALL);
    }

    /**
     * Read by key method
     * 
     * @param int $index
     * 
     * @return
     */
    function readByKey(int $index)
    {

        // Check access
        if (!$this->options->ACCESS_READ || !$this->options->tableKey) return;

        // Set conditions
        $this->setConditions("{$this->options->tableKey} = {$index}");

        return $this->read();
    }
}

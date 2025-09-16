<?php

/*
|-----------------------------
|       CURD ( Delete )
|-----------------------------
|
|
*/

namespace TOOL\SQL\Curd;

use TOOL\SQL\SQL;

final class Delete
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
     * Statement
     * 
     * @var ?SQL
     */
    private ?SQL $statemet = null;


    /**
     * Delete __construct
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
     * Prepare Method
     * 
     */
    function prepare()
    {

        // Check access
        if (!$this->options->ACCESS_DELETE) return;

        // Query
        $Query = "DELETE FROM {$this->options->table} WHERE {$this->conditions}";

        // Set Statement
        $this->statemet = SQL::set($Query);
    }

    /**
     * Set method
     * 
     * @param array $params
     * 
     * @return
     */
    function set(array $params = [])
    {
        return $this->statemet->exec($params);
    }

    /**
     * Delete method
     * 
     * @param array $params
     * 
     * @return
     */
    function delete(array $params = [])
    {

        // Check access
        if (!$this->options->ACCESS_DELETE) return;

        // Query
        $Query = "DELETE FROM {$this->options->table} WHERE {$this->conditions}";

        // Exec SQL
        return SQL::set($Query)->exec($params);
    }

    /**
     * Delete by key method
     * 
     * @param int $index
     * 
     * @return
     */
    function deleteByKey(int $index)
    {

        // Check access
        if (!$this->options->ACCESS_DELETE || !$this->options->tableKey) return;

        // Set conditions
        $this->setConditions("{$this->options->tableKey} = {$index}");

        return $this->delete();
    }
}

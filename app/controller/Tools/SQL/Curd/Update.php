<?php

/*
|-----------------------------
|       CURD ( Update )
|-----------------------------
|
|
*/

namespace TOOL\SQL\Curd;

use TOOL\SQL\SQL;

final class Update
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
     * Update __construct
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
     * Prepare method
     * 
     * @param array $columns
     * 
     */
    function prepare(array $columns)
    {

        // Check access
        if (!$this->options->ACCESS_UPDATE) return;

        // Columns string
        $columnsString = '';

        // Create prepare
        foreach ($columns as $column) {

            $columnsString .= "{$column} = :{$column},";
        }

        $columnsString = rtrim($columnsString, ",");

        // Query
        $Query = "UPDATE {$this->options->table} SET {$columnsString} WHERE {$this->conditions}";

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
    function set(array $params)
    {
        return $this->statemet->exec($params);
    }

    /**
     * Update method
     * 
     * @param array $params
     * 
     * @param array $needly
     * 
     * @return
     */
    function update(array $params, array $needly = [])
    {

        // Check access
        if (!$this->options->ACCESS_UPDATE) return;

        // Define params string
        $paramsString = '';

        // Set params string
        foreach (array_keys($params) as $key) {

            // Check needly
            if ($needly && !in_array($key, $needly)) continue;

            // Append params string
            $paramsString .= "{$key} = :{$key},";
        }

        $paramsString = rtrim($paramsString, ",");

        // Query
        $Query = "UPDATE {$this->options->table} SET {$paramsString} WHERE {$this->conditions}";

        // Exec SQL
        return SQL::set($Query)->exec($params);
    }

    /**
     * Update by key method
     * 
     * @param array $params
     * 
     * @return
     */
    function updateByKey(array $params)
    {

        // Check access
        if (!$this->options->ACCESS_UPDATE || !$this->options->tableKey) return;

        // Get Key
        $key = intval($params[$this->options->tableKey]);

        // Check key
        if (!$key) return;

        // Remove key from params
        unset($params[$this->options->tableKey]);

        // Set conditions
        $this->setConditions("{$this->options->tableKey} = {$key}");

        return $this->update($params);
    }
}

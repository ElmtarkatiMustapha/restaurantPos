<?php

/*
|-----------------------------
|       CURD ( Insert )
|-----------------------------
|
|
*/

namespace TOOL\SQL\Curd;

use TOOL\Security\Auth;
use TOOL\SQL\SQL;

final class Insert
{

    /**
     * Options
     * 
     * @var object
     */
    private object $options;

    /**
     * Statement
     * 
     * @var ?SQL
     */
    private ?SQL $statement = null;

    /**
     * Columns
     * 
     * @var array
     */
    private array $columns;


    /**
     * Insert __construct
     * 
     * @param array $options
     */
    function __construct(array $options)
    {
        $this->options = (object) $options;
    }

    /**
     * Set columns method
     * 
     * @param array $columns
     */
    function setColumns(array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * Prepare Method
     * 
     * @param int $indexs
     * 
     * @return self
     */
    function prepare(int $indexs = 1)
    {

        // Check access
        if (!$this->options->ACCESS_CREATE) return;

        // Get columns string
        $columnsString = implode(",", $this->columns);

        // Rows
        $rowsString = '';

        // Crete prepare
        for ($i = 0; $i < $indexs; $i++) {

            // Map columns
            $row = array_map(function ($column) use ($i) {

                return ":{$column}{$i}";
            }, $this->columns);

            // Append to rows string
            $rowString = implode(",", $row);
            $rowsString .= "({$rowString}),";
        }

        $rowsString = rtrim($rowsString, ",");

        // Query
        $Query = "INSERT INTO {$this->options->table} ({$columnsString}) VALUES {$rowsString}";

        // Set Statement
        $this->statement = SQL::set($Query);

        return $this;
    }

    /**
     * Save method
     * 
     * @param array $params
     * 
     * @return
     */
    function save(array $params)
    {

        // Check statement
        if (!$this->statement)
            $this->prepare(sizeof($params));

        // Define uniform params
        $uniformParams = [];

        // Set params with and without filter
        $params = array_map(function ($row, $index) use (&$uniformParams) {

            // Set one row params
            foreach ($this->columns as $column) {

                $uniformParams[$column . $index] = @$row[$column];
            }

            return null;
        }, $params, array_keys($params));

        // Exec SQL
        return $this->statement->exec($uniformParams, SQL::LAST_INSERT);
    }

    /**
     * Insert method
     * 
     * @param array $params
     * 
     * @return
     */
    function insert(array $params)
    {

        // Check access
        if (!$this->options->ACCESS_CREATE) return;

        // Define params string
        $paramsString = '';

        // Auto append create by auth
        if ($this->options->AUTO_CREATE_BY && Auth::loggedIn())
            $params['create_by'] = Auth::loggedIn()->id;

        // Set params string
        foreach (array_keys($params) as $key) {

            $paramsString .= "{$key} = :{$key},";
        }

        $paramsString = rtrim($paramsString, ",");

        // Query 
        $Query = "INSERT INTO {$this->options->table} SET {$paramsString}";

        // Exec SQL
        return SQL::set($Query)->exec($params, SQL::LAST_INSERT);
    }
}

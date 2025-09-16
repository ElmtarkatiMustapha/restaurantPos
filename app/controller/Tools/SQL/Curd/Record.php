<?php

/*
|-----------------------------
|       CURD ( Record )
|-----------------------------
|
|
*/

namespace TOOL\SQL\Curd;

use TOOL\HTTP\RES;
use TOOL\SQL\SQL;

final class Record
{

    /**
     * Curd options
     * 
     * @var object
     */
    private object $curdOptions;

    /**
     * Record options
     * 
     * @var object
     */
    private object $recordOptions;

    /**
     * Record
     * 
     * @var string
     */
    private string $record;

    /**
     * Max rows
     * 
     * @var int
     */
    private int $maxRows = 100000000;

    /**
     * All
     * 
     * @var bool
     */
    private bool $all = true;

    /**
     * Conditions
     * 
     * @var string
     */
    private string $conditions = 'TRUE';

    /**
     * Orders
     * 
     * @var string
     */
    private string $orders = '';

    /**
     * Params
     * 
     * @var int $page
     */
    private int $page = 1;

    /**
     * Params
     * 
     * @var array
     */
    private array $params = [];

    /**
     * Rows statement
     * 
     * @var ?SQL
     */
    private ?SQL $rowsStatemet = null;

    /**
     * Rusults statement
     * 
     * @var ?SQL
     */
    private ?SQL $resultsStatement = null;


    /**
     * Record __construct
     * 
     * @param array $curdOptions
     * 
     * @param array $recordOptions
     */
    function __construct(array $curdOptions, array $recordOptions)
    {
        $this->curdOptions = (object) $curdOptions;
        $this->recordOptions = (object) $recordOptions;

        // Set record
        $this->record = $this->recordOptions->record
            ??
            $this->curdOptions->record
            ??
            "SELECT * FROM {$this->curdOptions->table}";

        // Set max rows
        $this->maxRows = intval($this->recordOptions->maxRows ?? 500000000);
    }

    /**
     * Set filter method
     * 
     * @param string $condition
     * 
     * @param array $params
     * 
     * @param $use
     */
    function setFilter(string $condition, array $params = [], $use = true)
    {

        // Check using
        if (!$use) return false;

        // Append to conditions string
        $this->conditions .= " {$condition}";

        // Append to params
        if ($params) $this->params += $params;
    }

    /**
     * Set order method
     * 
     * @param string $orderBy
     * 
     * @param ?string $sort
     */
    function setOrder(string $orderBy, ?string $sort = 'asc')
    {

        // Check condition
        if (!$sort) return false;

        // Set sort
        $sort = $sort === 'desc' ? 'DESC' : 'ASC';

        // Append to orders
        $this->orders .= "{$orderBy} {$sort},";
    }

    /**
     * Rows prepare method
     * 
     */
    private function rowsPrepare()
    {

        // Get columns
        $columns = $this->recordOptions->columns ?? "*";

        // Get conditions
        $conditions = $this->conditions ? rtrim("WHERE {$this->conditions}", ",") : '';

        // Get orders
        $orders = $this->orders ? rtrim("ORDER BY {$this->orders}", ",") : '';

        // Add one to make sure there are rows left
        $maxRows = $this->maxRows + 1;

        // Get limited
        $limited = $this->all ? '' : "LIMIT {$maxRows} OFFSET :offset";

        // Generate query
        $Query = "SELECT {$columns}
            FROM (
                {$this->record}
            ) AS record
            {$conditions}
            {$orders}
            {$limited}";


        $this->rowsStatemet = SQL::set($Query);
    }

    /**
     * Results prepare method
     * 
     */
    private function resultsPrepare()
    {

        // Get columns
        $columns = rtrim("COUNT(*) AS rowsCount,{$this->recordOptions->results}", ",");

        // Get conditions
        $conditions = $this->conditions ? rtrim("WHERE {$this->conditions}", ",") : '';


        // Generate query
        $Query = "SELECT {$columns}
            FROM (
                {$this->record}
            ) AS record
            {$conditions}";

        $this->resultsStatement = SQL::set($Query);
    }

    /**
     * Prepare method
     * 
     * @param ?bool $results
     * 
     * @param ?bool $all
     * 
     * @return self
     */
    function prepare(?bool $results = true, ?bool $all = false): self
    {

        // Set all
        $this->all = (bool) $all;

        // Rows prepare
        $this->rowsPrepare();

        // Results prepare
        if ($results) $this->resultsPrepare();

        return $this;
    }

    /**
     * Page method
     * 
     * @param ?int $page
     * 
     * @return self
     */
    function page(?int $page = 1): self
    {

        $this->page = $page ? $page : 1;

        return $this;
    }

    /**
     * Get method
     * 
     * @param array $params
     * 
     * @return RES
     */
    function get(array $params = [])
    {

        // Check statement
        if (!$this->rowsStatemet)
            $this->prepare();

        // Append filters params
        $params += $this->params;

        // Params rows
        $paramsRows = $params;

        // Append offset to params rows
        if (!$this->all) $paramsRows['offset'] = ($this->page - 1) * $this->maxRows;

        // Exec rows statement
        $rows = $this->rowsStatemet->ferchAll($paramsRows);

        // Check response
        if ($rows->type !== 1)
            return $rows;

        // Exec results statement
        if ($this->resultsStatement) {

            $results = $this->resultsStatement->exec($params);

            // Check results response
            if ($results->type !== 1)
                return $results;
        }

        // Without results
        else $results = null;

        // Count rows
        $countRows = sizeof($rows->data);

        // Check more and remove the added row
        if ($more = $countRows > $this->maxRows && !$this->all)
            array_pop($rows->data);


        // Generate data
        $data = (object) [
            'rows' => $rows->data,
            'results' => $results->data,
            'properties' => [
                'page' => $this->page,
                'more' => $more,
                'countFound' => ($this->page - 1) * $this->maxRows + ($more ? $countRows - 1 : $countRows)
            ]
        ];

        return RES::return(RES::SUCCESS, null, $data);
    }
}

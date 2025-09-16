<?php

/*
|-----------------------------
|       CURD ( Where )
|-----------------------------
|
|
*/

namespace TOOL\SQL\Curd;

final class Where
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
    private string $conditions = 'FALSE';


    /**
     * Where __construct
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
     * @param $conditions
     */
    function setConditions($conditions)
    {

        // Conditions is string
        if (is_string($conditions))
            $this->conditions = $conditions;

        // Check table key
        else if ($this->options->tableKey) {

            // Conditions is int
            if (is_int($conditions))
                $this->conditions = "{$this->options->tableKey} = {$conditions}";

            // Conditions is ints array
            else if (is_array($conditions)) {

                $keys = implode(",", array_map('intval', $conditions));
                $this->conditions = "{$this->options->tableKey} IN ({$keys})";
            }
        }

        // Invalid conditions
        else
            $this->conditions = 'FALSE';
    }

    /**
     * Prepare update method
     * 
     * @param array $columns
     * 
     * @return Update
     */
    function prepareUpdate(array $columns)
    {

        // New Update
        $Update = new Update((array) $this->options);

        // Set conditions
        $Update->setConditions($this->conditions);

        // Prepare
        $Update->prepare($columns);

        return $Update;
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

        // New Update
        $Update = new Update((array) $this->options);

        // Set conditions
        $Update->setConditions($this->conditions);

        return $Update->update($params, $needly);
    }

    /**
     * Prepare read method
     * 
     * @param string $columns
     * 
     * @return Read
     */
    function prepareRead(string $columns = "*")
    {

        // New Read
        $Read = new Read((array) $this->options);

        // Set conditions
        $Read->setConditions($this->conditions);

        // Prepare
        $Read->select($columns)->prepare();

        return $Read;
    }

    /**
     * Read method
     * 
     * @param array $params
     * 
     * @return
     */
    function read(array $params = [])
    {

        // New Read
        $Read = new Read((array) $this->options);

        // Set conditions
        $Read->setConditions($this->conditions);

        return $Read->read($params);
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

        // New Read
        $Read = new Read((array) $this->options);

        // Set conditions
        $Read->setConditions($this->conditions);

        return $Read->readAll($params);
    }

    /**
     * Select method
     * 
     * @param string $columns
     * 
     * @return Read
     */
    function select(string $columns)
    {

        // New Read
        $Read = new Read((array) $this->options);

        // Set conditions
        $Read->setConditions($this->conditions);

        // Set columns
        $Read->select($columns);

        return $Read;
    }

    /**
     * Prepare delete method
     * 
     * @return Delete
     */
    function prepareDelete()
    {

        // New Read
        $Delete = new Delete((array) $this->options);

        // Set conditions
        $Delete->setConditions($this->conditions);

        // Prepare
        $Delete->prepare();

        return $Delete;
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

        // New Delete
        $Delete = new Delete((array) $this->options);

        // Set conditions
        $Delete->setConditions($this->conditions);

        return $Delete->delete($params);
    }
}

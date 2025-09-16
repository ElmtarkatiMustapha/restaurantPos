<?php

/*
|-----------------------------
|            CURD
|-----------------------------
|
|
*/

namespace TOOL\SQL\Curd;

final class Curd
{

    /**
     * Curd options
     * 
     * @var array
     */
    protected array $curdOptions;


    /**
     * Curd __construct
     * 
     * @param array $options
     */
    function __construct(array $options)
    {
        $this->curdOptions = $options;
    }

    /**
     * Table method
     * 
     * @param string $name
     * 
     * @param string $key
     */
    static function table(string $name, string $key = 'id')
    {

        return new self([
            'table' => $name,
            'tableKey' => $key,
            'ACCESS_CREATE' => TRUE,
            'ACCESS_UPDATE' => TRUE,
            'ACCESS_READ' => TRUE,
            'ACCESS_DELETE' => TRUE
        ]);
    }

    /**
     * Insert method
     * 
     * @param array $params
     * 
     * @return object
     */
    function insert(array $params)
    {

        // New Insert
        $Insert = new Insert($this->curdOptions);

        return $Insert->insert($params);
    }

    /**
     * Where method
     * 
     * @param $conditions
     * 
     * @return Where
     */
    function where($conditions)
    {

        // New Where
        $Where = new Where($this->curdOptions);

        // Set conditions
        $Where->setConditions($conditions);

        return $Where;
    }

    /**
     * Update method
     * 
     * @param array $params
     * 
     * @return object
     */
    function update(array $params)
    {

        // New Update
        $Update = new Update($this->curdOptions);

        return $Update->updateByKey($params);
    }

    /**
     * Read method
     * 
     * @param int $index
     * 
     * @return object
     */
    function read(int $index)
    {

        // New Read
        $Read = new Read($this->curdOptions);

        return $Read->readByKey($index);
    }

    /**
     * Delete method
     * 
     * @param int $index
     * 
     * @return object
     */
    function delete(int $index)
    {

        // New Delete
        $Delete = new Delete($this->curdOptions);

        return $Delete->deleteByKey($index);
    }

    /**
     * Prepare insert method
     * 
     * @param array $columns
     * 
     * @return Insert
     */
    function prepareInsert(array $columns)
    {

        // New Insert
        $Insert = new Insert($this->curdOptions);

        // Set columns
        $Insert->setColumns($columns);

        return $Insert;
    }

    /**
     * Prepare record method
     * 
     * @param array $options
     * 
     * @return Record
     */
    function prepareRecord(array $options = [])
    {

        // New Record
        $Record = new Record($this->curdOptions, $options);

        return $Record;
    }
}

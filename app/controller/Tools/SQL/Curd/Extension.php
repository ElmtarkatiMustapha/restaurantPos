<?php

/*
|-----------------------------
|       CURD Extension
|-----------------------------
|   use as extends classes
|
*/

namespace TOOL\SQL\Curd;

class Extension
{

    /**
     * Curd options
     * 
     * @var array
     */
    protected static array $curdOptions;


    /**
     * Insert method
     * 
     * @param array $params
     * 
     * @return
     */
    static function insert(array $params)
    {

        // New Insert
        $Insert = new Insert(static::$curdOptions);

        return $Insert->insert($params);
    }

    /**
     * Where method
     * 
     * @param $conditions
     * 
     * @return Where
     */
    static function where($conditions)
    {

        // New Where
        $Where = new Where(static::$curdOptions);

        // Set conditions
        $Where->setConditions($conditions);

        return $Where;
    }

    /**
     * Update method
     * 
     * @param array $params
     * 
     * @return
     */
    static function update(array $params)
    {

        // New Update
        $Update = new Update(static::$curdOptions);

        return $Update->updateByKey($params);
    }

    /**
     * Read method
     * 
     * @param int $index
     * 
     * @return
     */
    static function read(int $index)
    {

        // New Read
        $Read = new Read(static::$curdOptions);

        return $Read->readByKey($index);
    }

    /**
     * Delete method
     * 
     * @param int $index
     * 
     * @return
     */
    static function delete(int $index)
    {

        // New Delete
        $Delete = new Delete(static::$curdOptions);

        return $Delete->deleteByKey($index);
    }

    /**
     * Upsert method
     * 
     * @param int $key
     * 
     * @param array $insert
     * 
     * @param array $update
     * 
     * @return
     */
    static function upsert(?int $key, array $insert, array $update = [])
    {

        // Set update as insert if not exists
        if (!$update) $update = $insert;

        // Mode update
        if ($key && static::$curdOptions['tableKey']) {

            return self::update($update + [

                // Append key param
                static::$curdOptions['tableKey'] => $key
            ]);
        }

        // Mode insert
        else if (!$key)
            return self::insert($insert);
    }

    /**
     * Prepare insert method
     * 
     * @param array $columns
     * 
     * @return Insert
     */
    static function prepareInsert(array $columns)
    {

        // New Insert
        $Insert = new Insert(static::$curdOptions);

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
    protected static function prepareRecord(array $options = [])
    {

        // New Record
        $Record = new Record(static::$curdOptions, $options);

        return $Record;
    }
}

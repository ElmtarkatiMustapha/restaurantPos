<?php

namespace TOOL\SQL;

use TOOL\HTTP\RES;

class SQL
{

    /**
     * FETCH
     * 
     * @var int
     */
    const FETCH = 1;

    /**
     * FETCH_ALL
     * 
     * @var int
     */
    const FETCH_ALL = 2;

    /**
     * LAST_INSERT
     * 
     * @var string
     */
    const LAST_INSERT = 3;

    /**
     * SQL string
     * 
     * @var string
     */
    private string $string;

    /**
     * PDO statement
     * 
     * @var ?\PDOStatement
     */
    private ?\PDOStatement $statement = null;


    /**
     * SQL __construct
     * 
     * @param string $string
     */
    private function __construct(string $string)
    {
        $this->string = $string;
    }


    /** 
     * Set SQL method
     * 
     * @param string $string
     * 
     * @return self
     **/
    public static function set(string $string)
    {
        return new self($string);
    }

    /** 
     * Exec SQL
     * 
     * @param array $parameters
     * 
     * @param int $return
     * 
     * @return RES
     **/
    function exec(array $parameters = [], int $return = self::FETCH)
    {


        // Set Statement if not exsits
        if (!$this->statement)
            $this->statement = Database::conn()->prepare($this->string);

        // Exec statement
        $this->statement->execute($parameters);

        // Get results
        switch ($return) {

            case self::FETCH:
                $results = $this->statement->fetch(\PDO::FETCH_OBJ);
                break;

            case self::FETCH_ALL:
                $results = $this->statement->fetchAll(\PDO::FETCH_OBJ);
                break;

            case self::LAST_INSERT:
                $results = (object) [
                    'id' => Database::conn()->lastInsertId()
                ];
                break;

            default:
                $results = null;
        }


        return RES::return(RES::SUCCESS, null, $results);
    }

    /** 
     * Fetch method
     * 
     * @return RES
     */
    function ferch(array $parameters = [])
    {

        return $this->exec($parameters, self::FETCH);
    }

    /** 
     * Fetch all method
     * 
     * @return RES
     */
    function ferchAll(array $parameters = [])
    {

        return $this->exec($parameters, self::FETCH_ALL);
    }


    /** 
     * Save method
     * 
     * @return RES
     */
    function save(array $parameters = [])
    {

        return $this->exec($parameters, self::LAST_INSERT);
    }

    /**
     * Run method
     * 
     * @param string $sqlString
     */
    static function run(string $sqlString)
    {

        // Exec SQL
        Database::conn()->exec($sqlString);
    }


    /**
     * Run file method
     * 
     * @param string $filepath
     * 
     * @return RES
     */
    static function runFile(string $filepath)
    {

        // Is readable
        if (is_readable($filepath)) {

            // Include sql string
            $sqlString = file_get_contents($filepath);

            return self::run($sqlString);
        }

        // Is not exists or not readable
        else
            return RES::return(RES::ERROR);
    }
}

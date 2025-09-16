<?php

/*
|-----------------------------
|        RESException
|-----------------------------
|
|
*/


namespace TOOL\HTTP;


class RESException extends \Exception
{

    /**
     * Res
     * 
     * @var RES
     */
    public RES $res;


    /**
     * RESException __construct
     * 
     * @param ?string $message
     * 
     * @param int $type
     * 
     * @param $data
     */
    function __construct(?string $message, int $type = RES::ERROR, $data = null)
    {

        $this->res = new RES($type, $message, $data);

        parent::__construct($message);
    }
}

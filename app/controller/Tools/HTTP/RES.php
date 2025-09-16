<?php

/*
 |--------------------
 |      RESPONSE
 |--------------------
 |
 */


namespace TOOL\HTTP;

use Throwable;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as WhoopsRun;

class RES
{

    /**
     * TYPES
     * 
     */
    const ERROR = 0;
    const SUCCESS = 1;
    const WARNING = 2;
    const INVALID = 3;
    const UNAUTH = 4;
    const UNAPI = 5;
    const UNROLE = 6;
    const USERETURN = 10;


    /**
     * Type
     * 
     * @var int
     */
    public int $type;

    /**
     * Message
     * 
     * @var ?string
     */
    public ?string $message;

    /**
     * Data
     * 
     * @var
     */
    public $data;


    /**
     * RES __construct
     * 
     * @param int $type
     * 
     * @param ?string $message
     * 
     * @param $data
     */
    function __construct(int $type, ?string $message, $data = null)
    {

        $this->type = $type;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * Return method
     * 
     * @param int $type
     * 
     * @param ?string $message
     * 
     * @param $data
     * 
     * @return self
     */
    static function return(int $type, ?string $message = null, $data = null)
    {
        return new self($type, $message, $data);
    }

    /**
     * Write method
     * 
     * @param string $content
     * 
     * @param string $contentType
     */
    static function write(string $content, string $contentType = 'text/plan')
    {
        // Clean old content
        ob_end_clean();

        // Set content type
        header("Content-type: {$contentType}");

        // Write content
        die($content);
    }

    /**
     * Debug method
     * 
     * @param $error
     */
    static function debug(Throwable $error)
    {
        $whoops = new WhoopsRun();
        $whoops->pushHandler(new PrettyPageHandler)->register();
        throw $error;
    }

    /**
     * Print method
     * 
     */
    function print()
    {
        self::write(json_encode([
            'type' => $this->type,
            'message' => $this->message,
            'data' => $this->data
        ]), 'application/json; charset=utf-8');
    }

    /**
     * Throw method
     * 
     * @param array $exceptions
     */
    function throw(array $exceptions = [RES::ERROR])
    {

        if (in_array(
            $this->type,
            $exceptions
        ))
            throw new RESException($this->message, $this->type, $this->data);
    }

    /**
     * Add data method
     * 
     * @param $data
     */
    function addData($data)
    {

        $this->data = array_merge(
            $this->data,
            $data
        );
    }
}

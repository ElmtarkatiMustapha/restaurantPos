<?php

/*
 |-----------------
 |      Route
 |-----------------
 |
 */


namespace TOOL\HTTP;

use Error;
use Mimey\MimeTypes;

class Route
{

    /**
     * BREAK
     * 
     * @var int
     */
    public const BREAK = -1;

    /**
     * Close
     * 
     * @var bool
     */
    private static bool $close = false;

    /**
     * Break
     * 
     * @var bool
     */
    private static bool $break = false;

    /**
     * Parent URI
     * 
     * @var array
     */
    private static array $parentURI = [];

    /**
     * Params
     * 
     * @var array
     */
    public static array $params = [];


    /**
     * Run routes
     * 
     * @param $action
     * 
     * @param bool $recovery
     */
    public static function ready($action, bool $recovery = true)
    {

        // Open the route
        self::$close = false;

        // Check save to the old parend
        $parentURI = self::$parentURI;

        // Try action as callback
        if (is_callable($action))
            call_user_func($action, (object) self::$params);

        // Try require action as file
        else if (is_string($action))
            require $action;

        // Check back to the old parend
        if ($recovery) self::$parentURI = $parentURI;

        // Close the route
        self::$close = true;
    }

    /**
     * Path method
     * 
     * @param ?string $methods
     * 
     * @param string $to
     * 
     * @param $action
     * 
     * @param bool $group
     */
    private static function path(?string $methods, string $to, $action = null, bool $group = false)
    {

        // Check that the route is open
        // And There is no break process
        if (self::$close || self::$break) return;

        // Check the methods request
        if ($methods && !in_array(REQ::$method, explode('|', $methods)))
            return;

        // Extracting the URI of the child
        $ChildURI = array_slice(
            REQ::$uri,
            sizeof(self::$parentURI),
            sizeof(REQ::$uri)
        );

        // Extract the desired URI
        $to = REQ::uri($to);

        // Removing the starting point in the event of an parent path
        if (self::$parentURI) array_shift($to);

        // Check sure the path is complete
        if (!$group && sizeof($ChildURI) > sizeof($to)) return;

        // Road comparison
        foreach ($to as $index => $route) {

            # Check the URI is variable
            if ($route && $route[0] === ':') {
                self::$params[ltrim($route, ':')] = $ChildURI[$index];
                continue;
            }

            # URI comparison
            if ($route != $ChildURI[$index])
                return;
        }

        // Parent URI update
        self::$parentURI = array_merge(self::$parentURI, $to);

        // Try action as callback
        if (is_callable($action))
            call_user_func($action, (object) self::$params);

        // Try include action as file
        else if (is_string($action))
            require $action;

        // Close the route
        self::$close = true;
    }

    /**
     * To route
     * 
     * @param string $to
     * 
     * @param $action
     */
    public static function to(string $to, $action, ?string $methods = null)
    {
        self::path($methods, $to, $action);
    }

    /**
     * Group routes
     * 
     * @param string $to
     * 
     * @param $action
     */
    public static function group(string $to, $action, ?string $methods = null)
    {
        self::path($methods, $to, $action, true);
    }

    /**
     * Default route
     * 
     * @param $action
     */
    public static function default($action)
    {
        self::path(null, '/', $action);
    }

    /**
     * GETS routes
     * 
     * @param string $to
     * 
     * @param $action
     */
    public static function gets(string $to, $action)
    {
        self::path('GET', $to, $action, true);
    }

    /**
     * GET route
     * 
     * @param string $to
     * 
     * @param $action
     */
    public static function get(string $to, $action)
    {
        self::path('GET', $to, $action);
    }

    /**
     * POSTS routes
     * 
     * @param string $to
     * 
     * @param $action
     * 
     */
    public static function posts(string $to, $action)
    {
        self::path('POST', $to, $action, true);
    }

    /**
     * POST route
     * 
     * @param string $to
     * 
     * @param $action
     */
    public static function post(string $to, $action)
    {
        self::path('POST', $to, $action);
    }

    /**
     * ELSE route
     * 
     * @param $action
     * 
     * @param bool $mandatory
     */
    public static function else($action, bool $mandatory = false)
    {

        // Check that the route is open
        // Or There is break process
        // Or There is a mandatory pass
        if (self::$close && !self::$break && !$mandatory) return;

        // Stop the break
        self::$break = false;

        // Try action as callback
        if (is_callable($action))
            call_user_func($action, (object) self::$params);

        // Try include action as file
        else if (is_string($action))
            require $action;

        // Try action as constant actions
        else if ($action === self::BREAK)
            self::break();

        // Close the route
        self::$close = true;
    }

    /**
     * Extract params
     * 
     * @param ?string $prop
     * 
     * @return
     */
    static function params(?string $prop = null)
    {

        // Extract saved variables
        if ($prop)
            return self::$params[$prop];
        else
            return (object) self::$params;
    }

    /**
     * Break to Else
     * 
     */
    static function break()
    {
        self::$break = true;
    }

    /**
     * Create root method
     * 
     * @param string $root
     * 
     * @param ?string $index
     * 
     * @param ?string $notFound
     */
    static function createRoot(string $root, ?string $index = null, ?string $notFound = null)
    {

        // Check root
        if (!realpath($root))
            throw new Error("Not found \"{$root}\" root");

        // Extracting the URI of the child
        $ChildURI = implode("/", array_slice(
            REQ::$uri,
            sizeof(self::$parentURI),
            sizeof(REQ::$uri)
        ));

        // Check child url
        if (!$ChildURI) $ChildURI = $index ? $index : '';

        // Define real path
        $realPath = realpath("{$root}/{$ChildURI}");

        // Check real path
        if ((!$realPath || is_dir($realPath)) && $notFound)
            $realPath = realpath("{$root}/{$notFound}");

        // Check file
        if (!is_file($realPath)) return;

        // Define content type
        $contentType = (new MimeTypes)->getMimeType(pathinfo($realPath, PATHINFO_EXTENSION));

        // Write file
        RES::write(file_get_contents($realPath), $contentType);
    }
}

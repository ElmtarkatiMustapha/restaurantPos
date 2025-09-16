<?php


namespace TOOL\Console;

class Console
{

    /**
     * Args
     * 
     * @var array $args
     */
    static array $args;

    /**
     * Props
     * 
     * @var object $props
     */
    static object $props;

    /**
     * Route
     * 
     * @var int $route
     */
    private static int $route = 1;


    /**
     * Setup method
     * 
     * @param array $args
     */
    static function setup(array $args)
    {

        // Set args
        self::$args = array_values(array_filter($args, function ($arg) {
            return substr($arg, 0, 2) !== '--';
        }));

        // Remove first element
        unset(self::$args[0]);

        // Define props
        $props = array_filter($args, function ($arg) {
            return substr($arg, 0, 2) === '--';
        });

        // Set props
        self::$props = (object) [];

        foreach ($props as $prop) {

            // Remove prop symbol
            $prop = substr($prop, 2);

            // With value
            if ($key = strstr($prop, '=', true))
                self::$props->{$key} = substr($prop, strpos($prop, '=') + 1);

            // Without value
            else
                self::$props->{$prop} = true;
        }
    }

    /**
     * Route method
     * 
     * @param string $arg
     * 
     * @param string $action
     * 
     * @return string
     */
    static function route(string $arg, $action)
    {

        // Check route
        if ($arg !== self::$args[self::$route]) return;

        // Next arg
        self::$route = self::$route + 1;

        // Try action as callback
        if (is_callable($action))
            call_user_func($action, array_slice(self::$args, self::$route - 1));

        // Try include action as file
        else if (is_string($action))
            require $action;

        exit;
    }
}

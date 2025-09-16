<?php

use TOOL\Helper\Lang;
use TOOL\Helper\Template;
use TOOL\System\App;

/**
 * Config method
 * 
 */
if (!function_exists('config')) {
    function config(string $key, $default = null)
    {
        // Define value as default
        $value = $default;

        try {

            // Check key if define
            if (isset(App::config()->{$key}))
                $value = App::config()->{$key};

            // Set as default value
            else
                $value = $default;
        } catch (Throwable $error) {
            unset($error);
        } finally {
            return $value;
        }
    }
}

/**
 * Lang method
 * 
 */
if (!function_exists('lang')) {
    function lang(string $word)
    {

        return Lang::tran($word);
    }
}

/**
 * Template method
 * 
 */
if (!function_exists('template')) {
    function template(string $path, array $params = [])
    {

        return Template::get(Template::BASE . $path, $params);
    }
}

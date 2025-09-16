<?php

use TOOL\Console\Console;

/*
 |-----------------------------
 |      SET CONSOLE CONFIG
 |-----------------------------
 |
 */

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set(config('TIMEZONE'));
set_time_limit(1000000);


/*
 |-----------------------------
 |           SETUP
 |-----------------------------
 | Console::$args
 | Console::$props
 */
Console::setup($argv);

try {
    /*
    |-----------------------------
    |        CONSOLE ROUTES
    |-----------------------------
    |
    */
    require __DIR__ . '/routes.php';
} catch (Throwable $error) {

    /*
    |-----------------------------
    |        HANDLE DEBUG
    |-----------------------------
    |
    */

    echo "\n----------------------------------\n";
    echo "\033[31m" . $error->getMessage() . " \033[0m";
    echo "\n----------------------------------\n";
    echo "\033[36m";

    foreach ($error->getTrace() as $trace) {
        $trace = (object) $trace;
        echo "- {$trace->file} ($trace->line)\n";
    }

    echo "\033[0m";
    echo "----------------------------------\n\n";
}

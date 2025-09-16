<?php

use TOOL\HTTP\REQ;
use TOOL\HTTP\RES;

/*
 |-----------------------------
 |      SET HTTP CONFIG
 |-----------------------------
 |
 */

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set(config('TIMEZONE'));
set_time_limit(300);


/*
 |-----------------------------
 |        SETUP REQUEST
 |-----------------------------
 | REQ::$uri
 | REQ::$query
 | REQ::$method
 | REQ::$input
 | REQ::$auth
 | REQ::$custom
 */
REQ::setup();


try {

    /*
     |-----------------------------
     |         HTTP ROUTES
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
    if (config('APP_DEBUG', false))
        RES::debug($error);

    else
        RES::write(template('/error/500.php'), 'text/html');
}

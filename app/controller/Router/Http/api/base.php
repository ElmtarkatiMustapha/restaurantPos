<?php

use TOOL\HTTP\RES;
use TOOL\HTTP\RESException;

/*
 |-----------------------------
 |        SET API HEADER
 |-----------------------------
 |
 */

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

try {

    /*
     |-----------------------------
     |         API ROUTES
     |-----------------------------
     |
     */
    require __DIR__ . '/routes.php';
} catch (RESException $response) {

    /*
     |-----------------------------
     |       HANDLE RESPONSE
     |-----------------------------
     |
     */
    $response->res->print();
} catch (Throwable $error) {

    /*
     |-----------------------------
     |        HANDLE DEBUG
     |-----------------------------
     |
     */
    if (config('APP_DEBUG', false))
        RES::return(
            RES::ERROR,
            $error->getMessage(),
            $error->getTrace()
        )->print();

    else
        RES::return(
            RES::ERROR,
            'Internal error'
        )->print();
}

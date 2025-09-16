<?php

use APP\Order;
use APP\POS;
use TOOL\HTTP\REQ;
use TOOL\HTTP\RES;
use TOOL\HTTP\Route;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------ 
 |
 */

Auth::header(['admin', 'cashier', "manager"]);

Order::fullPayment(Route::params()->id,REQ::$input->amountProvided);

try {

    POS::paymentPrint(Route::params()->id);
} catch (Throwable $error) {

    unset($error);
}

RES::return(RES::SUCCESS)->print();

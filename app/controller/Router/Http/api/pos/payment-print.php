<?php

use APP\POS;
use TOOL\HTTP\Route;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin', 'cashier', "manager"]);

POS::paymentPrint(Route::params()->id)->print();

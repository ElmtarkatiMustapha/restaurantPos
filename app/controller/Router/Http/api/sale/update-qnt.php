<?php

use APP\Sale;
use TOOL\HTTP\REQ;
use TOOL\HTTP\Route;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin', 'cashier',"manager"]);

Sale::updateQnt(Route::params()->id, REQ::$input)->print();

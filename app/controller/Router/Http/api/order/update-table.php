<?php

use APP\Order;
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

Order::updateTable(Route::params()->id, REQ::$input)->print();

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

Auth::header(['admin', 'cashier']);

// Order::get(Route::params()->id)->print();
Order::reprinting(Route::params()->id,REQ::$input->equipedIn)->print();

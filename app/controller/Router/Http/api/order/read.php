<?php

use APP\Order;
use TOOL\HTTP\Route;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin', 'cashier', "manager"]);

Order::get(Route::params()->id)->print();

<?php

use APP\Daily;
use TOOL\HTTP\Route;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin', 'cashier',"manager"]);

Daily::report(Route::params()->id)->print();

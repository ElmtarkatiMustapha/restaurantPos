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

POS::kitchenPrint(Route::params()->id)->print();

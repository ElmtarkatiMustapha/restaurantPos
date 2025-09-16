<?php

use APP\Daily;
use TOOL\HTTP\REQ;
use TOOL\HTTP\Route;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin',"manager"]);

Daily::orders(Route::params()->id, REQ::$input)->print();

<?php

use APP\Expense;
use TOOL\HTTP\REQ;
use TOOL\Security\Auth;
use TOOL\HTTP\Route;
/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin']);

Expense::report(Route::params()->id)->print();

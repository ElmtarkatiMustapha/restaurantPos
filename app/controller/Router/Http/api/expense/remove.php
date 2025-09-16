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

Expense::remove(Route::params()->id, REQ::$input)->print();


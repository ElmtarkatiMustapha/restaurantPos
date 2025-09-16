<?php

use APP\Table;
use TOOL\HTTP\REQ;
use TOOL\HTTP\Route;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin']);

Table::customUpdate(Route::params()->id, REQ::$input)->print();

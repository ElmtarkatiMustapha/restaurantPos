<?php

use APP\Category;
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

Category::customUpdate(Route::params()->id, REQ::$input)->print();

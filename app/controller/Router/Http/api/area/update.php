<?php

use APP\Area;
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

Area::customUpdate(Route::params()->id, REQ::$input)->print();

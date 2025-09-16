<?php

use APP\Area;
use TOOL\HTTP\Route;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin', 'cashier',"manager"]);

Area::read(Route::params()->id)->print();

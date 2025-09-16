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

Auth::header(['admin']);

Area::customDelete(Route::params()->id)->print();

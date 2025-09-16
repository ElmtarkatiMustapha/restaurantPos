<?php

use APP\Menu;
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

Menu::customUpdate(Route::params()->id, REQ::$input)->print();

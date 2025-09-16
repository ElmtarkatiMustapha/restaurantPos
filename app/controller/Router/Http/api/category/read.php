<?php

use APP\Category;
use TOOL\HTTP\Route;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin']);

Category::read(Route::params()->id)->print();

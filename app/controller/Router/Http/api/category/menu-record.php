<?php

use APP\Category;
use TOOL\HTTP\REQ;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin']);

Category::menuRecord(REQ::$input)->print();

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

Auth::header(['admin', 'cashier',"manager"]);

Category::record(REQ::$input)->print();

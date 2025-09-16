<?php

use APP\Menu;
use TOOL\HTTP\REQ;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin', 'cashier', "manager"]);

Menu::category(REQ::$input)->print();

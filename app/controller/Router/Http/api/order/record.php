<?php

use APP\Order;
use TOOL\HTTP\REQ;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin', 'cashier', 'manager']);

if(Auth::loggedIn()->type != "admin" && Auth::loggedIn()->type != "manager"){
    Order::record(REQ::$input, Auth::loggedIn()->username)->print();
}else{
    Order::record(REQ::$input, "admin")->print();
}

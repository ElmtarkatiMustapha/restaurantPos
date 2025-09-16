<?php

use APP\User;
use TOOL\HTTP\REQ;
use TOOL\HTTP\RES;
use TOOL\Security\Auth;

Auth::header(['admin', 'cashier',"manager"]);
if(isset(REQ::$query->username) && !empty(REQ::$query->username)){
    User::raport(REQ::$query->username, REQ::$query)->print();
}else{
    User::raport(Auth::loggedIn()->username, REQ::$query)->print();
}
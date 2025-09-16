<?php

use APP\User;
use TOOL\HTTP\REQ;
use TOOL\Security\Auth;

Auth::header(['admin', 'cashier',"manager"]);
User::get_statistics(Auth::loggedIn()->username)->print();

<?php

use APP\Settings;
use TOOL\HTTP\REQ;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin']);

Settings::setTicket(REQ::$input)->print();

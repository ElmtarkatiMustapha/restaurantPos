<?php

use TOOL\HTTP\RES;
use TOOL\System\Update;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin']);

RES::return(RES::SUCCESS, null, Update::search())->print();

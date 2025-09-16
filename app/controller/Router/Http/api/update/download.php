<?php

use TOOL\HTTP\REQ;
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

Update::download(REQ::$input->version);

RES::return(RES::SUCCESS)->print();

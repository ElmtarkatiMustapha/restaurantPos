<?php

use TOOL\HTTP\REQ;
use TOOL\HTTP\RES;
use TOOL\Security\Token;
session_start();
session_destroy();
Token::destroy(REQ::$auth);

RES::return(RES::SUCCESS)->print();

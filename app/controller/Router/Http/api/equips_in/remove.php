<?php

use APP\EquipsIn;
use TOOL\HTTP\REQ;
use TOOL\Security\Auth;

/*
|------------
|    AUTH
|------------
|
*/

Auth::header(['admin']);
EquipsIn::remove(REQ::$input)->print();

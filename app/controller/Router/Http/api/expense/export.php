<?php

use APP\Expense;
use TOOL\HTTP\REQ;
use TOOL\Security\Auth;
/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin']);

Expense::export(REQ::$input)->print();

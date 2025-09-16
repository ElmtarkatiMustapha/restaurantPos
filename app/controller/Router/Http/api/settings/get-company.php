<?php

use APP\Settings;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin']);

Settings::getCompany()->print();

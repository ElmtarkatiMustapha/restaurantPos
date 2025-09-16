<?php

use APP\User;
use TOOL\HTTP\REQ;

User::setSession(REQ::$input)->print();


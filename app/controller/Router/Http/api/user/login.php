<?php

use APP\User;
use TOOL\HTTP\REQ;

User::login(REQ::$input)->print();

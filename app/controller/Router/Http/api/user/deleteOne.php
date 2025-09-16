<?php

use APP\User;
use TOOL\HTTP\REQ;

User::deleteOne(REQ::$input)->print();

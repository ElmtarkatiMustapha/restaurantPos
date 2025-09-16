<?php

use APP\User;
use TOOL\HTTP\REQ;

User::loginCard(REQ::$input)->print();

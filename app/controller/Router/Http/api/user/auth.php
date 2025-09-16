<?php

use TOOL\HTTP\RES;
use TOOL\Security\Auth;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header();

RES::return(
    RES::SUCCESS,
    null,
    [
        'details' => Auth::loggedIn()
    ]
)->print();

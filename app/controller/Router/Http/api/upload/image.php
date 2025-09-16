<?php

use TOOL\Security\Auth;
use TOOL\Upload\Image;

/*
 |------------
 |    AUTH
 |------------
 |
 */

Auth::header(['admin']);

Image::upload($_FILES['files'])->print();

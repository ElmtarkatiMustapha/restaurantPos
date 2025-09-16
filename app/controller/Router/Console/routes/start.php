<?php

use TOOL\Console\Console;
use TOOL\System\Path;

// Web
if (Console::$props->web)
    Path::open(BASEINTERFACE)
        ->go('web')
        ->command("npm start");

// Mobile
else if (Console::$props->mobile)
    Path::open(BASEINTERFACE)
        ->go('mobile')
        ->command("npm run dev");

// Server
else
    Path::open(BASEDIR)
        ->command('explorer "http://localhost:8888"')
        ->command('php -S localhost:8888 index.php');

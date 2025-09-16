<?php

use TOOL\System\Path;

Path::open(BASEDIR)
    ->go('usage')
    ->command('explorer "http://localhost:9000"')
    ->command('php -S localhost:9000 index.php');

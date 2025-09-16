<?php

use TOOL\Console\Console;
use TOOL\System\App;
use TOOL\System\Path;

echo "Create backup... \n";
$filename = App::backup();
echo $filename . "\n";

// Copy to disk
if (Console::$props->disk) {
    echo "Copy to " . Console::$props->disk . "\n";
    Path::open(Console::$props->disk)->make('workspace/' . date("Y-m-d"))->do(function ($path) use ($filename) {
        copy(BASESTORAGE . "/backups/{$filename}", "{$path}/{$filename}");
    });
}

echo "Done  \n";

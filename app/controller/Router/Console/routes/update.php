<?php

use TOOL\Console\Console;
use TOOL\System\Update;

echo "Updating... \n";
Update::download(Console::$props->version);
echo "Done \n";

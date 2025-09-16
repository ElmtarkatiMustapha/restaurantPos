<?php

use TOOL\Console\Console;
use TOOL\System\Update;

echo "Generate new version \n";
$version = Update::generateVersion((bool) Console::$props->stable);
echo "Version << {$version->number} >> ({$version->type}) has generated";

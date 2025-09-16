<?php

use TOOL\HTTP\RES;
use TOOL\System\Update;

/*
 |-----------------------------
 |        VERIFY UPDATE
 |-----------------------------
 |
 */

try {

    Update::verify();
} catch (Throwable $error) {

    RES::write("Update error: " . $error->getMessage() . " (" . $error->getLine() . ")");
}

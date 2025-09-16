<?php

/**
 * |------------------------
 * |      APPLICATION
 * |------------------------
 */

define('BASEDIR', __DIR__);

/*
 |-----------------------------
 |          AUTOLOAD
 |-----------------------------
 |
 */
require_once BASEDIR . '/controller/vendor/autoload.php';

/*
 |-----------------------------
 |            HTTP
 |-----------------------------
 |
 */
require_once BASEROUTER . '/http/app.php';

# END
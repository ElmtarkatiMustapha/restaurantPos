<?php

use TOOL\HTTP\Route;

/**
 * |------------------------
 * |         DAILY
 * |------------------------
 */


Route::to('/renewal', __DIR__ . '/renewal.php');
Route::to('/report/:id', __DIR__ . '/report.php');
Route::to('/record', __DIR__ . '/record.php');
Route::to('/export', __DIR__ . '/export.php');
Route::to('/orders/:id', __DIR__ . '/orders.php');

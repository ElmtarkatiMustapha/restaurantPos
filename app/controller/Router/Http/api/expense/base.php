<?php

use TOOL\HTTP\Route;

/**
 * |------------------------
 * |         DAILY
 * |------------------------
 */

Route::to('/renewal', __DIR__ . '/renewal.php');
Route::to('/record', __DIR__ . '/record.php');
Route::to('/create', __DIR__ . '/create.php');
Route::to('/export', __DIR__ . '/export.php');
Route::to('/report/:id', __DIR__ . '/report.php');
Route::to('/expense/:id', __DIR__ . '/expense.php');
Route::to('/remove/:id', __DIR__ . '/remove.php');

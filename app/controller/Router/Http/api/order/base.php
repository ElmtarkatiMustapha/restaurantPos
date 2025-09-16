<?php

use TOOL\HTTP\Route;

/**
 * |------------------------
 * |         ORDER
 * |------------------------
 */

Route::to('/read/:id', __DIR__ . '/read.php');
Route::to('/delete/:id', __DIR__ . '/delete.php');
Route::to('/record', __DIR__ . '/record.php');
Route::to('/full-payment/:id', __DIR__ . '/full-payment.php');
Route::to('/update-table/:id', __DIR__ . '/update-table.php');

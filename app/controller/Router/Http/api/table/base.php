<?php

use TOOL\HTTP\Route;

/**
 * |------------------------
 * |         MENU
 * |------------------------
 */

Route::to('/create', __DIR__ . '/create.php');
Route::to('/read/:id', __DIR__ . '/read.php');
Route::to('/delete/:id', __DIR__ . '/delete.php');
Route::to('/update/:id', __DIR__ . '/update.php');
Route::to('/record', __DIR__ . '/record.php');

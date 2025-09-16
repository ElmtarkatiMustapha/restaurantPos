<?php

use TOOL\HTTP\Route;

/**
 * |------------------------
 * |         Category
 * |------------------------
 */

Route::to('/create', __DIR__ . '/create.php');
Route::to('/record', __DIR__ . '/record.php');
Route::to('/delete/:id', __DIR__ . '/delete.php');
Route::to('/read/:id', __DIR__ . '/read.php');
Route::to('/update/:id', __DIR__ . '/update.php');
Route::to('/list', __DIR__ . '/list.php');

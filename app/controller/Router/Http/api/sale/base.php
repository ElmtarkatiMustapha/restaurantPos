<?php

use TOOL\HTTP\Route;

/**
 * |------------------------
 * |         SALE
 * |------------------------
 */

Route::to('/delete/:id', __DIR__ . '/delete.php');
Route::to('/update-qnt/:id', __DIR__ . '/update-qnt.php');

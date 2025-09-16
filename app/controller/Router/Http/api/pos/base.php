<?php

use TOOL\HTTP\Route;

/**
 * |------------------------
 * |         POS
 * |------------------------
 */

Route::to('/order/:id', __DIR__ . '/order.php');
Route::to('/kitchen-print/:id', __DIR__ . '/kitchen-print.php');
Route::to('/bartender-print/:id', __DIR__ . '/bartender-print.php');
Route::to('/cashier-print/:id', __DIR__ . '/cashier-print.php');
Route::to('/payment-print/:id', __DIR__ . '/payment-print.php');
Route::to('/add-items/:id', __DIR__ . '/add-items.php'); 

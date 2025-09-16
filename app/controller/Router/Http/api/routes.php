<?php

use TOOL\HTTP\Route;
use TOOL\HTTP\RES;

/**
 * Default API
 * 
 */
Route::default(function () {
    RES::return(RES::SUCCESS, 'Welcome to API system')->print();
});

/**
 * API routes
 * 
 */
Route::posts('/user', __DIR__ . '/user/base.php');
Route::posts('/upload', __DIR__ . '/upload/base.php');
Route::posts('/update', __DIR__ . '/update/base.php');
Route::posts('/settings', __DIR__ . '/settings/base.php');
Route::posts('/category', __DIR__ . '/category/base.php');
Route::posts('/menu', __DIR__ . '/menu/base.php');
Route::posts('/area', __DIR__ . '/area/base.php');
Route::posts('/table', __DIR__ . '/table/base.php');
Route::posts('/customer', __DIR__ . '/customer/base.php');
Route::posts('/pos', __DIR__ . '/pos/base.php');
Route::posts('/daily', __DIR__ . '/daily/base.php');
Route::posts('/expense', __DIR__ . '/expense/base.php');
Route::posts('/order', __DIR__ . '/order/base.php');
Route::posts('/equips_in', __DIR__ . '/equips_in/base.php');
Route::posts('/sale', __DIR__ . '/sale/base.php');
Route::posts('/session', __DIR__ . '/session/session.php');
/**
 * API has not found
 * 
 */
Route::else(function () {
    RES::return(RES::UNAPI, 'API has not found')->print();
}, true);

<?php

use TOOL\HTTP\Route;

/**
 * |------------------------
 * |        SETTINGS
 * |------------------------
 */

Route::to('/get-printers', __DIR__ . '/get-printers.php');
Route::to('/set-printers', __DIR__ . '/set-printers.php');
Route::to('/get-company', __DIR__ . '/get-company.php');
Route::to('/set-company', __DIR__ . '/set-company.php');
Route::to('/get-ticket', __DIR__ . '/get-ticket.php');
Route::to('/set-ticket', __DIR__ . '/set-ticket.php');
Route::to('/get-report', __DIR__ . '/get-report.php');
Route::to('/set-report', __DIR__ . '/set-report.php');
Route::to('/get-caissier', __DIR__ . '/get-caissier.php');
Route::to('/add-caissier', __DIR__ . '/add-caissier.php');

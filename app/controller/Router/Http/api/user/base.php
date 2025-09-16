<?php

use TOOL\HTTP\Route;

/**
 * |------------------------
 * |         USER
 * |------------------------
 */

Route::to('/login', __DIR__ . '/login.php');
Route::to('/loginCard', __DIR__ . '/loginCard.php');
Route::to('/auth', __DIR__ . '/auth.php');
Route::to('/logout', __DIR__ . '/logout.php');
Route::to('/profile', __DIR__ . '/profile.php');
Route::to('/get-statistics', __DIR__ . '/get-statistics.php');
Route::to('/raport', __DIR__ . '/userRaport.php');
Route::to('/get-all', __DIR__ . '/get-all.php');
Route::to('/setSession', __DIR__ . '/setSession.php');
Route::to('/deleteOne', __DIR__ . '/deleteOne.php');

<?php

use TOOL\HTTP\REQ;
use TOOL\HTTP\Route;

/*
 |-------------------------
 |       HTTP ROUTES
 |-------------------------
 |
 */

# API (POST OR OPTIONS)
Route::group('/api', __DIR__ . '/api/base.php', 'POST|OPTIONS');

# UPLOADS (GET)
Route::gets('/uploads', function () {
    Route::createRoot(BASEUPLOAD);
    Route::break();
});

# RESOURCES (GET)
Route::gets('/resources', function () {
    Route::createRoot(BASEPUBLIC . '/resources');
    Route::break();
});

# TEST (GET)
Route::to('/test', __DIR__ . '/test.php');

# PUBLIC ROOT (ALL)
Route::else(function () {

    // For mobile
    if (REQ::fromMobile())
        Route::createRoot(BASEPUBLIC . '/mobile', 'index.html', 'index.html');

    // For web
    else
        Route::createRoot(BASEPUBLIC . '/web', 'index.html', 'index.html');
});

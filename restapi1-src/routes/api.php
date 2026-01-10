<?php

use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Api\ApiController::class)
    ->middleware([EnsureTokenIsValid::class])
    ->group(function () {
        Route::get('/get', 'get');
        Route::post('/search', 'search');
    });

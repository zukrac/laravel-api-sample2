<?php

use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\Api\ApiController::class)
    ->middleware([EnsureTokenIsValid::class])
    ->group(function () {
        Route::get('/get', 'get');
        Route::post('/search', 'search');
    });

Route::controller(\App\Http\Controllers\Api\CommentController::class)
    ->middleware([EnsureTokenIsValid::class])
    ->group(function () {
        Route::get('/comments', 'index');
        Route::post('/comments', 'store');
        Route::get('/comments/{id}', 'show');
        Route::put('/comments/{id}', 'update');
        Route::delete('/comments/{id}', 'destroy');
        Route::get('/comments/{id}/replies', 'replies');
    });

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TmaStoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/{provider}', [AuthController::class, 'index']);
Route::get('/auth/{provider}/callback', [AuthController::class, 'callback']);

Route::get('/tma/{store:slug}', [TmaStoreController::class, 'index']);

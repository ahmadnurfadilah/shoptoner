<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/{provider}', [AuthController::class, 'index']);

Route::get('/auth/{provider}/callback', [AuthController::class, 'callback']);

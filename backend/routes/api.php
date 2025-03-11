<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

Route::post('storeUser',[UserController::class, 'store']);

Route::post('login',[AuthController::class, 'login']);
Route::get('role',[AuthController::class, 'role']);

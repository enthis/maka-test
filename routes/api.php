<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'index']);
Route::post('/', [UserController::class, 'store']);
Route::get('/{id}', [UserController::class, 'show']);
Route::post('update/{id}', [UserController::class, 'update']);
Route::delete('/{id}', [UserController::class, 'destroy']);

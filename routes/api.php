<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/', [UserController::class, 'index']);
Route::post('/user/create', [UserController::class, 'store']);
Route::put('/user/edit/{id}', [UserController::class, 'update']);
Route::put('/user/delete/{id}', [UserController::class, 'update']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::get('/user/delete/{id}', [UserController::class, 'destroy']);
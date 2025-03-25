<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\CategoryController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('categories' , CategoryController::class);
// Route::apiResource('plants' , PlantController::class);

Route::get('/plants' , [ PlantController::class , 'index']);
Route::post('plants' , [ PlantController::class , 'store']);
Route::get('/plants/{plant:slug}' , [ PlantController::class , 'show']);
Route::patch('/plants/{plant:slug}' , [ PlantController::class , 'update']);
Route::delete('/plants/{plant:slug}' , [ PlantController::class , 'destroy']);

Route::apiResource('orders' , OrderController::class);
Route::put('orders/cancelation/{order}' , [OrderController::class , 'cancel']);







Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::get('/me', [AuthController::class, 'me']);


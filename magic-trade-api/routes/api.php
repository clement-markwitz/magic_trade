<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\TradeController;
use App\Http\Controllers\Api\TradeItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::prefix('cards')->group(function () {
    Route::get('',[CardController::class,'index']);
    Route::post('',[CardController::class,'store'])->middleware('auth:sanctum');
});
Route::prefix('trades')->group(function () {
    Route::get('',[TradeController::class,'index'])->middleware('auth:sanctum');
    Route::post('',[TradeController::class,'store'])->middleware('auth:sanctum');
    Route::post('{id}',[TradeController::class,'show'])->middleware('auth:sanctum');
    Route::put('{id}',[TradeController::class,'update'])->middleware('auth:sanctum');
    Route::post('item',[TradeItemController::class,'store'])->middleware('auth:sanctum');
});
Route::prefix('clients')->group(function () {
    Route::put('{id}',[ClientController::class,'update'])->middleware('auth:sanctum');
});
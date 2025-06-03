<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\TradeController;
use App\Http\Controllers\Api\TradeItemController;
use App\Http\Controllers\Api\UserCardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::prefix('cards')->group(function () {
    Route::get('',[CardController::class,'index']);
    Route::post('',[CardController::class,'store'])->middleware(['auth:sanctum','permission:add card']);
    Route::get('my',[CardController::class,'myCards'])->middleware(['auth:sanctum','permission:my cards']);
    Route::get('{id}',[CardController::class,'show'])->middleware(['auth:sanctum','permission:show card']);
    Route::get('userCards/{id}',[CardController::class,'showByUserCard'])->middleware(['auth:sanctum','permission:show by user card']);
   
});
Route::prefix('userCards')->group(function () {
    Route::get('',[UserCardController::class,'index']);
    Route::get('{id}',[UserCardController::class,'show']);
    Route::put('{id}',[UserCardController::class,'update'])->middleware(['auth:sanctum','permission:update user card']);
    Route::delete('{id}',[UserCardController::class,'destroy'])->middleware( ['auth:sanctum','permission:delete user card']);
    Route::get('{cardId}/{userId}',[UserCardController::class,'showByCardAndUserId']);
});
Route::prefix('trades')->group(function () {
    Route::get('',[TradeController::class,'index'])->middleware(['auth:sanctum','permission:list trades']);
    Route::post('',[TradeController::class,'store'])->middleware(['auth:sanctum','permission:create trade']);
    Route::get('my',[TradeController::class,'myTrades'])->middleware(['auth:sanctum','permission:my trades']);
    Route::post('item',[TradeItemController::class,'store'])->middleware(['auth:sanctum','permission:create trade item']);
    Route::post('leave/{id}',[TradeController::class,'leave'])->middleware(['auth:sanctum','permission:leave trade']);
    Route::post('accept/{id}',[TradeController::class,'accept'])->middleware(['auth:sanctum','permission:accept trade']);
    Route::post('complete/{id}',[TradeController::class,'complete'])->middleware(['auth:sanctum','permission:complete trade']);
    Route::post('cancel/{id}',[TradeController::class,'cancelTrade'])->middleware(['auth:sanctum','permission:cancel trade']);
    Route::post('{id}',[TradeController::class,'show'])->middleware(['auth:sanctum','permission:show trade']);
    Route::put('{id}',[TradeController::class,'update'])->middleware(['auth:sanctum','permission:update trade']);
});
Route::prefix('clients')->group(function () {
    Route::get('',[ClientController::class,'index'])->middleware(['auth:sanctum','permission:list clients']);
    Route::get('me',[ClientController::class,'me'])->middleware(['auth:sanctum','permission:me']);
    Route::put('{id}',[ClientController::class,'update'])->middleware(['auth:sanctum','permission:update client']);
    Route::get('{id}',[ClientController::class,'show'])->middleware(['auth:sanctum','permission:show client']);
});
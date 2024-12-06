<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CityGroupController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('states', StateController::class);
Route::apiResource('cities', CityController::class);
Route::apiResource('city-groups', CityGroupController::class);
Route::apiResource('campaigns', CampaignController::class);
Route::apiResource('discounts', DiscountController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('sales', SaleController::class);

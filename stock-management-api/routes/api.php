<?php

use App\Http\Controllers\Api\V1\SupplierController;
use App\Http\Controllers\Api\V1\CategoriesController;
use App\Http\Controllers\Api\V1\ItemController;
use App\Http\Controllers\Api\V1\PurchaseOrderController;
use App\Http\Controllers\Api\V1\ReceivingOrderController;
use App\Http\Controllers\Api\V1\BackOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::group(['prefix'=>'v1'],function() {
        Route::apiResource('categories',CategoriesController::class);
        Route::get('categories/{category}',[CategoriesController::class,'edit']);

        Route::apiResource('supplier',SupplierController::class);
        Route::apiResource('item',ItemController::class);
        Route::apiResource('purchase-order',PurchaseOrderController::class);
        Route::apiResource('receiving-order',ReceivingOrderController::class);
        Route::apiResource('back-order',BackOrderController::class);
        
    });
});

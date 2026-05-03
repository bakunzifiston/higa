<?php

use App\Http\Controllers\Api\V1\BatchExpenseController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\FarmerController;
use App\Http\Controllers\Api\V1\FinishedInventoryController;
use App\Http\Controllers\Api\V1\LocationController;
use App\Http\Controllers\Api\V1\MaizeCollectionController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProductPackageController;
use App\Http\Controllers\Api\V1\ProductionBatchController;
use App\Http\Controllers\Api\V1\RawInventoryController;
use App\Http\Controllers\Api\V1\SaleController;
use App\Http\Controllers\Api\V1\SaleReturnController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('v1')->group(function (): void {
    Route::apiResource('farmers', FarmerController::class);
    Route::apiResource('locations', LocationController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('product-packages', ProductPackageController::class)->parameters([
        'product-packages' => 'productPackage',
    ]);

    Route::get('maize-collections', [MaizeCollectionController::class, 'index']);
    Route::post('maize-collections', [MaizeCollectionController::class, 'store']);
    Route::get('maize-collections/{maizeCollection}', [MaizeCollectionController::class, 'show']);

    Route::get('raw-inventory/movements', [RawInventoryController::class, 'movements']);
    Route::get('raw-inventory/stock/{location}', [RawInventoryController::class, 'stockByLocation']);

    Route::get('production-batches', [ProductionBatchController::class, 'index']);
    Route::post('production-batches', [ProductionBatchController::class, 'store']);
    Route::get('production-batches/{batch}', [ProductionBatchController::class, 'show']);
    Route::get('batch-expenses', [BatchExpenseController::class, 'index']);
    Route::post('batch-expenses', [BatchExpenseController::class, 'store']);

    Route::get('finished-inventory/movements', [FinishedInventoryController::class, 'movements']);
    Route::get('finished-inventory/stock', [FinishedInventoryController::class, 'stock']);

    Route::get('sales', [SaleController::class, 'index']);
    Route::post('sales', [SaleController::class, 'store']);
    Route::get('sales/{sale}', [SaleController::class, 'show']);

    Route::get('sales-returns', [SaleReturnController::class, 'index']);
    Route::post('sales-returns', [SaleReturnController::class, 'store']);
    Route::get('payments', [PaymentController::class, 'index']);
    Route::post('payments', [PaymentController::class, 'store']);

    Route::get('dashboard', [DashboardController::class, 'index']);
});

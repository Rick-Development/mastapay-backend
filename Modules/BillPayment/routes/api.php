<?php

use Illuminate\Support\Facades\Route;
use Modules\BillPayment\Http\Controllers\VtpassController;

// Route::middleware('auth:sanctum')->group(function () {

Route::group(['middleware' => ['auth:sanctum','CheckVerificationApi']], function () {
        Route::prefix('vtpass')->group(function () {
            Route::get('/categories', [VtpassController::class, 'categories']);
            Route::get('/services/{identifier}', [VtpassController::class, 'services']);
            Route::get('/services/{serviceId}/variations', [VtpassController::class, 'variations']);
            Route::get('/services/{serviceId}/options/{optionName}', [VtpassController::class, 'options']);
            Route::post('/verify-meter', [VtpassController::class, 'verifyMeter']);
            Route::post('/purchase', [VtpassController::class, 'purchase']);
            
            Route::post('/requery', [VtpassController::class, 'requery']);
            Route::get('/balance', [VtpassController::class, 'balance']);
        });
});
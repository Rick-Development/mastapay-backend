<?php

use Illuminate\Support\Facades\Route;
use Modules\Giftcard\Http\Controllers\GiftcardController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('giftcards', GiftcardController::class)->names('giftcard');
});

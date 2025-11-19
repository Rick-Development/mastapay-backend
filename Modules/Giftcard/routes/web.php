<?php

use Illuminate\Support\Facades\Route;
use Modules\Giftcard\Http\Controllers\GiftcardController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('giftcards', GiftcardController::class)->names('giftcard');
});

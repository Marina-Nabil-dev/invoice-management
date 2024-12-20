<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoginController;

Route::post('/login', LoginController::class)->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('invoices', InvoiceController::class)->scoped([
        'invoice' => 'invoice_number'
    ]);
});


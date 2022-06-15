<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return inertia('welcome');
});

Route::get('product', ProductController::class)->name('product.index');
Route::get('select/categories', CategoryController::class)->name('select.categories');
Route::resource('customer', CustomerController::class)->except(['create', 'show', 'edit']);

Route::controller(PaymentController::class)->group(function () {
    Route::get('payment', 'index')->name('payment.index')->middleware('auth');
    Route::get('history', 'history')->name('payment.history')->middleware('auth');

    Route::post('redirect-payment', 'redirect')->name('redirect-payment');
    Route::post('webhook/ipaymu', 'webhook')->name('webhook.ipaymu');
});

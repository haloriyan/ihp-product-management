<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => "product"], function () {
    Route::get('create', [ProductController::class, 'create'])->name('product.create');
    Route::post('store', [ProductController::class, 'store'])->name('product.store');
    Route::post('delete', [ProductController::class, 'delete'])->name('product.delete');
    Route::delete('/', [ProductController::class, 'delete'])->name('product.delete');
    
    Route::group(['prefix' => "{id}"], function () {
        Route::get('edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('update', [ProductController::class, 'update'])->name('product.update');
    });
});
<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => "admin"], function () {
    Route::match(['get', 'post'], "login", [AdminController::class, 'login'])->name('admin.login');

    Route::group(['middleware' => "Admin"], function () {
        Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');

        include __DIR__."/product.php";
    });
});
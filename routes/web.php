<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.index');
});

include __DIR__."/admin.php";
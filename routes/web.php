<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::group(['middleware' => ['web']], function () {
    Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
    Route::get('/{slug}', [App\Http\Controllers\Frontend\HomeController::class, 'show'])->name('fe.page.show');
});
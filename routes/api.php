<?php

use App\Http\Controllers\NfeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth')->group(function () {
    Route::get('/nfe/{access_key}', [NfeController::class, 'show'])->name('nfe.show');
    Route::get('/download/{access_key}', [NfeController::class, 'download'])->name('nfe.download');
});

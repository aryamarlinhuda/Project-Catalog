<?php

use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(LoginController::class)->group(function() {
    Route::get('/','login_form');
    Route::post('login','login');
    Route::get('logout','logout');
});

Route::middleware(['admin'])->group(function() {
    Route::controller(DestinationController::class)->group(function() {
        Route::prefix('destination')->group(function() {
            Route::get('list','list');
        });
    });
});
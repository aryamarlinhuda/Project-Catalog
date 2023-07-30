<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function() {
    Route::post('register','register');
    Route::post('login','login');
    Route::post('refresh-token','refresh_token');
    Route::post('logout','logout');
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::controller(UserController::class)->group(function() {
        Route::prefix('user')->group(function() {
            Route::get('profile','profile');
            Route::post('edit-profile','edit_profile');
            Route::post('edit-password','edit_password');
            Route::post('save-destination','save_destination');
            Route::get('saved-destination','saved_destination');
            Route::get('user-review','user_review');            
        });
    });
    Route::controller(DestinationController::class)->group(function() {
        Route::get('list-province','list_province');
        Route::get('list-city','list_city');
        Route::get('list-city-by-province/{id}','list_city_by_province');
        Route::prefix('destination')->group(function() {
            Route::get('list','list');
            Route::get('{id}/detail','detail');
            Route::get('filter-by-category/{id}','filter_by_category');
            Route::get('filter-by-province/{id}','filter_by_province');
            Route::get('filter-by-city/{id}','filter_by_city');
        });
    });
    Route::controller(ReviewController::class)->group(function() {
        Route::prefix('review')->group(function() {
            Route::post('add','add_review');
            Route::post('edit','edit_review');
            Route::post('delete','delete_review');
        });
    });
});
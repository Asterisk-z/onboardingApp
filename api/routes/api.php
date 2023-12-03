<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\MemberCategoryController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\UsersController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [UsersController::class, 'login']);
    Route::post('/register', [UsersController::class, 'register']);
});

Route::get('/nationalities', [NationalityController::class, 'index']);
Route::get('/categories', [MemberCategoryController::class, 'index']);

Route::middleware('auth')->group(function () {


    Route::group(['prefix' => 'complaint'], function () {
        Route::post('/store', [ComplaintController::class, 'store']);
        Route::get('/', [ComplaintController::class, 'index']);
    });

    //MEG ROUTES

    Route::middleware('meg')->group(function () {
        Route::group(['prefix' => 'complaint'], function () {
            Route::post('/feedback', [ComplaintController::class, 'feedback']);
            Route::post('/status', [ComplaintController::class, 'changeStatus']);
        });
    });


    //MSG ROUTES

    //FSD ROUTES

    //MBG ROUTES

});

<?php

use App\Http\Controllers\MemberCategoryController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\UsersController;
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

Route::middleware('auth')->get('/user', function (Request $request) {
    return auth()->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [UsersController::class, 'login']);
    Route::post('/register', [UsersController::class, 'register']);
});

Route::get('/nationalities', [NationalityController::class, 'index']);
Route::get('/categories', [MemberCategoryController::class, 'index']);

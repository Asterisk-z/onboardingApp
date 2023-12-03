<?php

use App\Http\Controllers\ARController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\UsersController;
use App\Models\Role;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [UsersController::class, 'login']);
    Route::post('/register', [UsersController::class, 'register']);
});

Route::middleware('auth')->group(function () {

    Route::group(['prefix' => 'complaint'], function () {
        Route::post('/store', [ComplaintController::class, 'store']);
        Route::get('/', [ComplaintController::class, 'index']);
    });

    //MEG ROUTES

    Route::middleware('authRole:' . Role::MEG)->group(function () {
        Route::group(['prefix' => 'complaint'], function () {
            Route::post('/feedback', [ComplaintController::class, 'feedback']);
            Route::post('/status', [ComplaintController::class, 'changeStatus']);
        });
    });

    //MSG ROUTES

    //FSD ROUTES

    //MBG ROUTES


    // AR ROUTES
    $roles = [Role::ARAUTHORISER, Role::ARINPUTTER];
    $serializedRoles = serialize($roles);

    Route::middleware('authRole:' . Role::ARAUTHORISER . ',' . Role::ARINPUTTER)->group(function () {
        Route::group(['prefix' => 'ar'], function () {
            Route::post('/add', [ARController::class, 'add']);
            Route::get('/list', [ARController::class, 'list']);
        });
    });

});

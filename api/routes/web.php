<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\UsersController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [UsersController::class, 'login']);
    Route::post('/register', [UsersController::class, 'register']);
});

Route::group(['prefix' => 'audit'], function () {
    Route::post('/all-logs', [AuditController::class, 'index']);
    Route::post('/user-logs', [AuditController::class, 'userLog']);
});

Route::get('/', function () {
    return view('welcome');
});

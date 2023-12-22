<?php

use App\Http\Controllers\ARController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\BroadcastMessageController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintTypeController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\MemberCategoryController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RegulatorsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SanctionsController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Models\Role;
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

    Route::prefix('password')->group(function () {
        Route::post('/change', [PasswordController::class, 'changePassword'])->middleware('throttle:10,5');

        Route::prefix('reset')->group(function () {
            Route::post('/initiate', [PasswordController::class, 'forgotPassword']);
            Route::post('/otp', [PasswordController::class, 'validateForgotPasswordOtp'])->middleware('throttle:10,5');
            Route::post('/complete', [PasswordController::class, 'resetPassword'])->middleware('passwordReset');
        });
    });
});

Route::get('/nationalities', [NationalityController::class, 'index']);
Route::get('/positions', [PositionController::class, 'index']);
Route::get('/ar_roles', [RoleController::class, 'user_roles']);
Route::get('/admin_roles', [RoleController::class, 'admin_roles']);
Route::get('/categories', [MemberCategoryController::class, 'index']);
Route::post('/category/positions', [MemberCategoryController::class, 'positions']);
Route::get('/complaint-types', [ComplaintTypeController::class, 'index']);

Route::middleware('auth')->group(function () {

    Route::get('/system/configs', [SystemController::class, 'index']);

    Route::group(['prefix' => 'complaint'], function () {
        Route::post('/store', [ComplaintController::class, 'store']);
        Route::get('/', [ComplaintController::class, 'index']);
    });

    //
    Route::group(['prefix' => 'user'], function () {
        Route::get('/logs', [AuditController::class, 'userLog']);
    });

    //MEG ROUTES
    Route::middleware('authRole:' . Role::MEG)->group(function () {
        // complaint
        Route::group(['prefix' => 'complaint'],  function () {
            Route::post('/feedback', [ComplaintController::class, 'feedback']);
            Route::post('/status', [ComplaintController::class, 'changeStatus']);
            Route::get('/all', [ComplaintController::class, 'allComplaints']);
        });
        // audit
        Route::group(['prefix' => 'audits'],  function () {
            Route::get('/logs', [AuditController::class, 'index']);
        });
        //
        Route::group(['prefix' => 'meg/ar'],  function () {
            Route::get('/list', [ARController::class, 'listMEG']);
            Route::get('/transfer', [ARController::class, 'listTransferMEG']);

            Route::post('/process-add/{ARUser}', [ARController::class, 'processAddByMEG']);
            Route::post('/process-transfer/{record}', [ARController::class, 'processTransferByMEG']);
        });
        // broadcast
        Route::group(['prefix' => 'broadcasts'],  function () {
            Route::get('/view-messages', [BroadcastMessageController::class, 'index']);
            Route::post('/create-message', [BroadcastMessageController::class, 'store']);
        });
        // institutions
        Route::group(['prefix' => 'institution'],  function () {
            Route::get('/list', [InstitutionController::class, 'listInstitution']);
        });
        // Membership Category
        Route::group(['prefix' => 'membership/category'],  function () {
            Route::get('/list', [MemberCategoryController::class, 'listAll']);
            Route::post('/create', [MemberCategoryController::class, 'addCategory']);
            Route::post('/update/{category}', [MemberCategoryController::class, 'updateCategory']);
            Route::post('/update-status/{category}', [MemberCategoryController::class, 'changeStatusCategory']);
        });
        // Positions
        Route::group(['prefix' => 'meg/position'],  function () {
            Route::get('/list', [PositionController::class, 'listAll']);
            Route::post('/create', [PositionController::class, 'addPosition']);
            Route::post('/update/{position}', [PositionController::class, 'updatePosition']);
            Route::post('/update-status/{position}', [PositionController::class, 'changeStatusPosition']);
        });
        // Complaint
        Route::group(['prefix' => 'meg/complain-type'],  function () {
            Route::get('/list', [ComplaintTypeController::class, 'listAll']);
            Route::post('/create', [ComplaintTypeController::class, 'addComplainType']);
            Route::post('/update/{complainType}', [ComplaintTypeController::class, 'updateComplainType']);
            Route::post('/update-status/{complainType}', [ComplaintTypeController::class, 'changeStatusComplainType']);
        });
        // regulators
        Route::group(['prefix' => 'meg/regulators'],  function () {
            Route::get('/view_all', [RegulatorsController::class, 'index']);
            Route::post('/create', [RegulatorsController::class, 'store']);
            Route::post('/update/{id}', [RegulatorsController::class, 'update']);
            Route::post('/update-status/{id}', [RegulatorsController::class, 'updateStatus']);
        });
    });
    // CCO and MEG ROUTES
    Route::middleware('ccomeg')->group(function () {
        // sanctions
        Route::group(['prefix' => 'disciplinary-sanctions'],  function () {
            Route::get('/view-all', [SanctionsController::class, 'index']);
            Route::get('/fetch-ar', [SanctionsController::class, 'fetchAR']);
            Route::post('/create', [SanctionsController::class, 'store']);
            Route::post('/update/{id}', [SanctionsController::class, 'update']);
            Route::post('/delete/{id}', [SanctionsController::class, 'delete']);
        });
    });

    //MSG ROUTES

    //FSD ROUTES

    //MBG ROUTES

    //AR ROUTES
    Route::middleware('authRole:' . Role::ARAUTHORISER . ',' . Role::ARINPUTTER)->group(function () {
        Route::group(['prefix' => 'ar'], function () {
            Route::get('/list', [ARController::class, 'list']);
            Route::get('/search', [ARController::class, 'search']);
            Route::get('/view/{ARUser}', [ARController::class, 'view']);
            Route::post('/add', [ARController::class, 'add']);
            Route::post('/update/{ARUser}', [ARController::class, 'update']);
            Route::post('/cancel-update/{ARUser}', [ARController::class, 'cancelUpdate']);
            Route::post('/process-update/{ARUser}', [ARController::class, 'processUpdate']);

            Route::get('/transfer', [ARController::class, 'listTransfer']);
            Route::get('/change-status', [ARController::class, 'listStatusChange']);

            Route::post('/transfer/{ARUser}', [ARController::class, 'transfer']);
            Route::post('/process-transfer/{record}', [ARController::class, 'processTransfer']);

            Route::post('/change-status/{ARUser}', [ARController::class, 'changeStatus']);
            Route::post('/process-change-status/{record}', [ARController::class, 'processChangeStatus']);
        });
    });

    Route::group(['prefix' => 'user'], function () {
        Route::get('/authorisers', [UserController::class, 'list_ar_authorisers']);
    });
});

Route::get('execute-commands', [SystemController::class, 'executeCommands'])->name('executeCommands');
Route::get('clear-model/{model}', [SystemController::class, 'clearModel'])->name('clearModel');

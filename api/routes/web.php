<?php

use App\Helpers\ESuccessLetter;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\SystemController;
use App\Models\Application;
use App\Models\User;
use App\Notifications\InfoNotification;
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

Route::get('/', function () {
    return view('invoice');
});

Route::get('execute-commands', [SystemController::class, 'executeCommands'])->name('executeCommands');

Route::get('test-job', function () {
    $user = User::where('email', 'damilare.oluwole@fmdqgroup.com')->first();
    $user->notify(new InfoNotification('Just testing notification.', "my subject"));
    return response()->json(['message' => "Email sent. Did you receive?"]);
});

Route::get('applicant/invoice/{uuid}', [MembershipApplicationController::class, 'downloadApplicantInvoice'])->name('invoice');

Route::get('sample/certificate/{event}', [EventController::class, 'certificateSample']);
Route::get('sample/certificate/{event}/download', [EventController::class, 'certificateSampleDownload'])->name('certificateSampleDownload');

Route::get('/letter', function () {
    $application = Application::where('id', 1)->first();
    $content = ESuccessLetter::generate($application);
    // $content = (new ESuccessLetter())->generate($application);
    return view('success.e-letter', compact('content'));
// return view('success.letter');
// return view('success.letter');

});

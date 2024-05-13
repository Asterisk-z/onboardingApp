<?php

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\SystemController;
use App\Models\Application;
use App\Models\Role;
use App\Models\User;
// use Dompdf\Dompdf;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
    return view('welcome');
});

Route::get('execute-commands', [SystemController::class, 'executeCommands'])->name('executeCommands');

Route::get('test-job', function () {
    $applicant = User::where('email', 'daniel.olang@fmdqgroup.com')->first();

    // $user->notify(new InfoNotification('Just testing notification.', "my subject"));

// $applicant = User::find($application->submitted_by);
    $name = $applicant->first_name . ' ' . $applicant->last_name;

    $data = Application::where('applications.id', '2');
    $data = Utility::applicationDetails($data);
    $data = $data->first();

    $application = Application::find(2);
    $membershipCategory = $application->membershipCategory;

// CC email addresses
    $Meg = Utility::getUsersEmailByCategory(Role::MEG);

// NOTIFY APPLICANT AND SEND MEMBERSHIP AGREEMENT
    $emailData = [
        'name' => $name,
        'subject' => MailContents::memberAgreementSubject(),
        'content' => MailContents::memberAgreementMail(),
    ];
    logger('extedmsop');
    logger(Str::slug("{$membershipCategory->name} Membership Agreement", '-') . "." . pathinfo($membershipCategory->membership_agreement, PATHINFO_EXTENSION));
    $attachment = [
        [
            "name" => Utility::getFileName("{$membershipCategory->name} Membership Agreement", $membershipCategory->membership_agreement),
            "saved_path" => $membershipCategory->membership_agreement,
        ],
    ];

    Utility::notifyApplicantAndContact('2', $applicant, $emailData, $Meg, $attachment);

    return response()->json(['message' => "Email sent. Did you receive?"]);
});

Route::get('applicant/invoice/{uuid}', [MembershipApplicationController::class, 'downloadApplicantInvoice'])->name('invoice');

Route::get('sample/certificate/{event}', [EventController::class, 'certificateSample']);
Route::get('sample/certificate/{event}/download', [EventController::class, 'certificateSampleDownload'])->name('certificateSampleDownload');

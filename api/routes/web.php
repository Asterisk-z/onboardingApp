<?php

// use App\Helpers\EventNotificationUtility;

use App\Helpers\EventNotificationUtility;
use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\SystemController;
use App\Models\Application;
use App\Models\Education\EventRegistration;
use App\Models\MembershipCategory;
// use App\Models\Education\EventRegistration;
// use App\Models\MembershipCategory;
use App\Models\Role;
use App\Models\User;
// use Dompdf\Dompdf;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

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

    return "Yes";
        $membershipCategory = MembershipCategory::where('id', '1')->first();
        $membershipCategory = Utility::membershipCategoryLicense($membershipCategory);

        dd($membershipCategory);

        $oMerger = PDFMerger::init();


    // $oMerger->addPDF(storage_path('/app/public/' .$application->meg_executed_membership_agreement), 'all', 'P');
    // $oMerger->addPDF(storage_path('/app/public/' .$application->e_success_letter), 'all', 'P');
    $oMerger->addPDF('./new_file.pdf', 'all', 'P');
    $oMerger->addPDF('./new_file.pdf', 'all', 'P');

    $oMerger->merge('P');
    $oMerger->save('./memberx4.pdf');

    return view('welcome');
    $application = Application::find(1);

    $data = Application::where('applications.id', '1');
    $data = Utility::applicationDetails($data);
    $data = $data->first();

    $categoryName = $data->category_name;
    $companyName = $data->company_name;
    $companyEmail = $data->company_email;
    $primaryContactEmail = $data->primary_contact_email;

    $applicant = User::find($application->submitted_by);

    $emailData = [
        'name' => $companyName,
        'subject' => 'MROIS Application Rejected - Incomplete Documentation',
        'content' => "<pre>Please be informed that we could not continue with your application because of the following: </br></br>Reason: fskdfjsdf sdkfjfksdf skfjsdkf skfjsdkfjsdkf jkfsdfksjfkdjfksjfsk</pre>",
    ];
    $Meg = Utility::getUsersEmailByCategory(Role::MEG);
    Utility::notifyApplicantAndContact($application->id, $applicant, $emailData, $Meg);

    dd($application);

    // $invoice = Invoice::all();
    // dd(str_pad(count($invoice) + 1, 3, '0', STR_PAD_LEFT));

    // $mailgroup = MembershipCategoryPostition::where([
    //     'category_id' => 8,
    //     'position_id' => 2,
    // ])->first();
    // if ($mailgroup) {
    //     $group_mail = $mailgroup->groupMail ? $mailgroup->groupMail->email : '';

    // }
    // dd($mailgroup);
    // return view('agreement.afs');

    // dd(Event::all());
    // dd(EventRegistration::all());

    // $application = Application::find(1);

    // (new ESuccessLetter)->generate($application);

    return view('welcome');

    $event = EventRegistration::where('certificate_path', '!=', null)->first();
    EventNotificationUtility::certificate($event);

    return view('welcome');
});
Route::get('/mail', function () {
    $displayName = "sfksfjsff";
    $info = "<p>A new applicant, Drake Hardin, has successfully signed up on the FMDQX MROIS Portal</p>

<p>Thank You.</p>

<p>FMDQ Securities Exchange</p>";
    return view('mails.info', compact('displayName', 'info'));
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

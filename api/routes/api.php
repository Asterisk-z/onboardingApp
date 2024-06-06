<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\ApplicantGuidesController;
use App\Http\Controllers\ApplicationProcessController;
use App\Http\Controllers\ARController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\BroadcastMessageController;
use App\Http\Controllers\CompetencyController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ComplaintTypeController;
use App\Http\Controllers\DashboardControler;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeesAndDuesController;
use App\Http\Controllers\FsdApplicationController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\MbgApplicationController;
use App\Http\Controllers\Meg2ApplicationController;
use App\Http\Controllers\MegApplicationController;
use App\Http\Controllers\MemberCategoryController;
use App\Http\Controllers\MemberGuidesController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\MsgApplicationController;
use App\Http\Controllers\NationalityController;
use App\Http\Controllers\NotificationOfChangeController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\QpayController;
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
        Route::post('/set', [PasswordController::class, 'setPassword'])->middleware('throttle:10,5');

        Route::prefix('reset')->group(function () {
            Route::post('/initiate', [PasswordController::class, 'forgotPassword']);
            Route::post('/otp', [PasswordController::class, 'validateForgotPasswordOtp'])->middleware('throttle:10,5');
            Route::post('/complete', [PasswordController::class, 'resetPassword'])->middleware('passwordReset');
        });
    });

    Route::post('/stakeholder/access', [UserController::class, 'stakeholder_request']);

});

Route::get('/nationalities', [NationalityController::class, 'index']);
Route::get('/positions', [PositionController::class, 'index']);
Route::get('/position-group', [PositionController::class, 'groupList']);
Route::get('/ar_roles', [RoleController::class, 'user_roles']);
Route::get('/admin_roles', [RoleController::class, 'admin_roles']);
Route::get('/categories', [MemberCategoryController::class, 'index']);
Route::post('/category/positions', [MemberCategoryController::class, 'positions']);
Route::get('/complaint-types', [ComplaintTypeController::class, 'index']);
Route::get('/sanction-types', [SanctionsController::class, 'indexTypes']);

Route::middleware('auth')->group(function () {

    Route::get('/competency-list-name', [CompetencyController::class, 'listGroupName']);
    Route::get('/system/configs', [SystemController::class, 'index']);
    //
    Route::group(['prefix' => 'complaint'], function () {
        Route::post('/store', [ComplaintController::class, 'store']);
        Route::get('/', [ComplaintController::class, 'index']);
    });

    //
    Route::group(['prefix' => 'user'], function () {
        Route::get('/logs', [AuditController::class, 'userLog']);
    });

    Route::middleware('authRole:' . Role::MSG . ',' . Role::MEG . ',' . Role::FSD . ',' . Role::MBG . ',' . Role::BLG . ',' . Role::MEG2 . ',' . Role::BIG . ',' . Role::HELPDESK . ',' . Role::STAKEHOLDER)->group(function () {
        Route::get('admin/dashboard', [DashboardControler::class, 'adminDashboard']);

        // List AR For Admins
        Route::group(['prefix' => 'meg/ar'], function () {
            Route::get('/list', [ARController::class, 'listMEG']);
            Route::get('/transfer', [ARController::class, 'listTransferMEG']);
        });

        Route::group(['prefix' => 'membership/application'], function () {
            Route::get('/all_institutions', [ApplicationProcessController::class, 'all_institutions']);
        });

    });

    Route::middleware('authRole:' . Role::STAKEHOLDER . ',' . Role::MEG)->group(function () {

        Route::group(['prefix' => 'report/ar'], function () {
            Route::get('/list', [ARController::class, 'listReportMEG']);
        });

        // institutions
        Route::group(['prefix' => 'institution'], function () {
            Route::get('/list', [InstitutionController::class, 'listInstitution']);
        });

        Route::group(['prefix' => 'report/application'], function () {
            Route::get('/all_institution', [ApplicationProcessController::class, 'all_institution_report']);
        });
    });

    Route::middleware('authRole:' . Role::ARAUTHORISER . ',' . Role::ARINPUTTER)->group(function () {
        Route::group(['prefix' => 'ar'], function () {
            Route::get('/dashboard', [DashboardControler::class, 'arDashboard']);

            Route::get('/applications', [ApplicationProcessController::class, 'applications']);

            Route::get('/my-categories', [MemberCategoryController::class, 'myCategories']);
            Route::get('/my-application-categories', [MemberCategoryController::class, 'myApplicationCategories']);
            Route::get('/other-categories', [MemberCategoryController::class, 'otherCategories']);
        });
    });

    // MEG ROUTES
    Route::middleware('authRole:' . Role::MEG)->group(function () {
        // complaint
        Route::group(['prefix' => 'complaint'], function () {
            Route::post('/feedback', [ComplaintController::class, 'feedback']);
            Route::post('/status', [ComplaintController::class, 'changeStatus']);
            Route::get('/all', [ComplaintController::class, 'allComplaints']);
        });
        // audit
        Route::group(['prefix' => 'audits'], function () {
            Route::get('/logs', [AuditController::class, 'index']);
        });
        //
        Route::group(['prefix' => 'meg/ar'], function () {
            Route::post('/process-member-status/{ARUser}', [ARController::class, 'processMemberStatusMEG']);
            Route::post('/process-add/{ARUser}', [ARController::class, 'processAddByMEG']);
            Route::post('/process-transfer/{record}', [ARController::class, 'processTransferByMEG']);
        });
        // broadcast
        Route::group(['prefix' => 'broadcasts'], function () {
            Route::get('/view-messages', [BroadcastMessageController::class, 'index']);
            Route::post('/create-message', [BroadcastMessageController::class, 'store']);
        });

        // Membership Category
        Route::group(['prefix' => 'membership/category'], function () {
            Route::get('/list', [MemberCategoryController::class, 'listAll']);
            Route::post('/create', [MemberCategoryController::class, 'addCategory']);
            Route::post('/mapToPositions', [MemberCategoryController::class, 'mapToPositions']);
            Route::post('/unlinkFromPositions', [MemberCategoryController::class, 'unlinkFromPositions']);
            Route::post('/update/{category}', [MemberCategoryController::class, 'updateCategory']);
            Route::post('/update-status/{category}', [MemberCategoryController::class, 'changeStatusCategory']);
        });
        // Positions
        Route::group(['prefix' => 'meg/position'], function () {
            Route::get('/list', [PositionController::class, 'listAll']);
            Route::post('/create', [PositionController::class, 'addPosition']);
            Route::post('/mapToCategories', [PositionController::class, 'mapToCategories']);
            Route::post('/unlinkFromCategories', [PositionController::class, 'unlinkFromCategories']);
            Route::post('/update/{position}', [PositionController::class, 'updatePosition']);
            Route::post('/update-status/{position}', [PositionController::class, 'changeStatusPosition']);
        });
        // Complaint
        Route::group(['prefix' => 'meg/complain-type'], function () {
            Route::get('/list', [ComplaintTypeController::class, 'listAll']);
            Route::post('/create', [ComplaintTypeController::class, 'addComplainType']);
            Route::post('/update/{complainType}', [ComplaintTypeController::class, 'updateComplainType']);
            Route::post('/update-status/{complainType}', [ComplaintTypeController::class, 'changeStatusComplainType']);
        });
        // regulators
        Route::group(['prefix' => 'meg/regulators'], function () {
            Route::get('/view_all', [RegulatorsController::class, 'index']);
            Route::post('/create', [RegulatorsController::class, 'store']);
            Route::post('/update/{id}', [RegulatorsController::class, 'update']);
            Route::post('/update-status/{id}', [RegulatorsController::class, 'updateStatus']);
        });

        // stack holder
        Route::group(['prefix' => 'meg/stakeholder'], function () {
            Route::get('/active_list', [UserController::class, 'list_active_stakeholders']);
            Route::get('/view_all', [UserController::class, 'list_stakeholders']);
            Route::post('/create', [UserController::class, 'store']);
            Route::post('/update/{id}', [UserController::class, 'update']);
            Route::post('/update-status/{id}', [UserController::class, 'updateStatus']);
        });

        // sanctions
        Route::group(['prefix' => 'disciplinary-sanctions'], function () {
            Route::get('/list_all', [SanctionsController::class, 'index']);
            Route::post('/update-status', [SanctionsController::class, 'updateStatus']);
        });
        // competency
        Route::group(['prefix' => 'meg/competency-framework'], function () {
            Route::get('/list-group-name', [CompetencyController::class, 'listGroupName']);
            Route::get('/list-all', [CompetencyController::class, 'listAll']);
            Route::get('/list-compliant-ars/{id}', [CompetencyController::class, 'listCompliantArs']);
            Route::get('/list-non-complaint-ars/{id}', [CompetencyController::class, 'listNonCompliantArs']);
            Route::get('/list-all-compliant-ars', [CompetencyController::class, 'listAllCompliantArs']);
            Route::get('/list-all-non-complaint-ars', [CompetencyController::class, 'listAllNonCompliantArs']);
            Route::post('/create', [CompetencyController::class, 'store']);
            Route::post('/update/{id}', [CompetencyController::class, 'update']);
            Route::post('/update-status/{id}', [CompetencyController::class, 'updateStatus']);
            Route::post('/update-competency-status', [CompetencyController::class, 'megStatusCompetency']);
        });
        // fees and dues
        Route::group(['prefix' => 'meg/fees-and-dues'], function () {
            Route::get('/list_all', [FeesAndDuesController::class, 'listAll']);
            Route::post('/create', [FeesAndDuesController::class, 'store']);
            Route::post('/update/{id}', [FeesAndDuesController::class, 'update']);
            Route::post('/update-status/{id}', [FeesAndDuesController::class, 'updateStatus']);
        });
        // applicant guides
        Route::group(['prefix' => 'meg/applicant-guides'], function () {
            Route::get('/list-all', [ApplicantGuidesController::class, 'listAll']);
            Route::post('/create', [ApplicantGuidesController::class, 'store']);
            Route::post('/update/{id}', [ApplicantGuidesController::class, 'update']);
            Route::post('/update-status/{id}', [ApplicantGuidesController::class, 'updateStatus']);
        });
        // membership guides
        Route::group(['prefix' => 'meg/member-guides'], function () {
            Route::get('/list-all', [MemberGuidesController::class, 'listAll']);
            Route::post('/create', [MemberGuidesController::class, 'store']);
            Route::post('/update/{id}', [MemberGuidesController::class, 'update']);
            Route::post('/update-status/{id}', [MemberGuidesController::class, 'updateStatus']);
        });
    });

    // CCO ROUTES
    Route::middleware('cco')->group(function () {
        // sanctions
        Route::group(['prefix' => 'disciplinary-sanctions'], function () {
            Route::get('/my_sanctions', [SanctionsController::class, 'mySanction']);
            Route::post('/create', [SanctionsController::class, 'store']);
        });

        // competency
        Route::group(['prefix' => 'cco/competency'], function () {
            Route::get('/ar', [CompetencyController::class, 'listARCompetencies']);
            Route::post('/status', [CompetencyController::class, 'statusCompetency']);
        });
    });

    //MSG ROUTES
    Route::middleware('authRole:' . Role::MSG)->group(function () {
        Route::group(['prefix' => 'msg/ar-creation/request'], function () {
            Route::get('/', [MsgApplicationController::class, 'arCreationRequest']);
            Route::post('/review', [MsgApplicationController::class, 'reviewArSystemCreationRequest']);
        });
    });

    //FSD ROUTES
    Route::middleware('authRole:' . Role::FSD)->group(function () {
        Route::group(['prefix' => 'membership/application/fsd'], function () {
            Route::get('/institutions', [FsdApplicationController::class, 'institutions']);
            Route::post('/payment-information', [FsdApplicationController::class, 'paymentInformation']);
            Route::post('/latest-payment-evidence', [FsdApplicationController::class, 'latestEvidence']);
            Route::post('/payment-details', [FsdApplicationController::class, 'paymentReviewDetails']);
            Route::post('/payment-review', [FsdApplicationController::class, 'fsdReview']);
        });
    });

    //MBG ROUTES
    Route::middleware('authRole:' . Role::MBG)->group(function () {
        Route::group(['prefix' => 'membership/application/mbg'], function () {
            Route::get('/institutions', [MbgApplicationController::class, 'institutions']);
            Route::post('/upload-concession', [MbgApplicationController::class, 'concession']);
            Route::post('/payment-information', [MbgApplicationController::class, 'paymentInformation']);
            Route::post('/latest-payment-evidence', [MbgApplicationController::class, 'latestEvidence']);
            Route::post('/payment-details', [MbgApplicationController::class, 'paymentReviewDetails']);
            Route::post('/fsd-review-summary', [MbgApplicationController::class, 'fsdReviewSummary']);
            Route::post('/review', [MbgApplicationController::class, 'mbgReview']);
        });

        Route::group(['prefix' => 'mbg/ar-creation/request'], function () {
            Route::get('/', [MbgApplicationController::class, 'arCreationRequest']);
            Route::post('/review', [MbgApplicationController::class, 'reviewArSystemCreationRequest']);
        });
    });

    //MEG ROUTES
    Route::middleware('authRole:' . Role::MEG)->group(function () {
        Route::group(['prefix' => 'membership/application/meg'], function () {
            Route::get('/institutions', [MegApplicationController::class, 'institutions']);
            Route::post('/review', [MegApplicationController::class, 'megReview']);
            //NEW API
            Route::post('/send-membership-agreement', [MegApplicationController::class, 'sendMembershipAgreement']);
            Route::post('/upload-membership-agreement', [MegApplicationController::class, 'uploadMemberAgreement']);
            Route::post('/complete-company-application', [MegApplicationController::class, 'completeCompanyApplication']);
        });

        Route::group(['prefix' => 'doh'], function () {
            Route::get('/signature', [MegApplicationController::class, 'getSignature']);
            Route::post('/signature', [MegApplicationController::class, 'createSignature']);
        });

        Route::group(['prefix' => 'sh/access'], function () {
            Route::get('/request', [AccessController::class, 'getAllRequest']);
            Route::post('/request', [AccessController::class, 'actionRequest']);
        });
    });

    //MEG2 ROUTES
    Route::middleware('authRole:' . Role::MEG2)->group(function () {
        Route::group(['prefix' => 'membership/application/meg2'], function () {
            Route::get('/institutions', [Meg2ApplicationController::class, 'institutions']);
            Route::post('/review', [Meg2ApplicationController::class, 'meg2Approval']);
            Route::post('/esuccess/approve', [Meg2ApplicationController::class, 'approveEsuccessLetter']);
        });
    });

    // AR ROUTES
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

            Route::get('/creation/request', [ARController::class, 'getArCreationRequest']);
            Route::post('/creation/request', [ARController::class, 'arCreationRequest']);
        });
        //
        Route::group(['prefix' => 'regulators'], function () {
            Route::get('/list', [RegulatorsController::class, 'list']);
        });
        //
        Route::group(['prefix' => 'competency'], function () {
            Route::get('/list-active', [CompetencyController::class, 'listActive']);
            Route::post('/submit-competency', [CompetencyController::class, 'submitCompetency']);
        });
        Route::group(['prefix' => 'membership/application'], function () {
            Route::get('/', [MembershipApplicationController::class, 'application']);
            Route::get('/get_application/{application_uuid}', [ApplicationProcessController::class, 'get_application']);
            Route::get('/all-fields', [MembershipApplicationController::class, 'getAllFields']);
            Route::get('/fields', [MembershipApplicationController::class, 'getField']);
            Route::get('/preview', [MembershipApplicationController::class, 'getPreview']);
            Route::get('/detail', [MembershipApplicationController::class, 'getDetail']);
            Route::get('/initial', [MembershipApplicationController::class, 'getInitial']);
            Route::get('/field/option', [MembershipApplicationController::class, 'getFieldOption']);
            Route::get('/extra', [MembershipApplicationController::class, 'getFieldExtra']);
            Route::post('/disclosure', [MembershipApplicationController::class, 'disclosure']);
            Route::post('/upload', [MembershipApplicationController::class, 'uploadField']);
            Route::post('/retain', [MembershipApplicationController::class, 'retainField']);
            Route::post('/invoice/download', [MembershipApplicationController::class, 'downloadInvoice']);
            Route::post('/upload-payment-proof', [MembershipApplicationController::class, 'uploadProofOfPayment']);
            Route::post('/online-payment', [MembershipApplicationController::class, 'onlinePayment']);
            Route::post('/complete', [MembershipApplicationController::class, 'complete']);
            Route::post('/upload-membership-agreement', [MembershipApplicationController::class, 'uploadMemberAgreement']);
            Route::post('/conversion-request', [ApplicationProcessController::class, 'conversionRequest']);
            Route::post('/addition-request', [ApplicationProcessController::class, 'additionRequest']);
        });
    });
    //
    Route::group(['prefix' => 'user'], function () {
        Route::get('/authorisers', [UserController::class, 'list_ar_authorisers']);
    });
    //
    Route::group(['prefix' => 'events'], function () {
        Route::get('/', [EventController::class, 'list']);
        Route::get('/view/{event}', [EventController::class, 'view']);
        Route::get('/registered', [EventController::class, 'myRegisteredEvents']);
        Route::get('/invited', [EventController::class, 'myInvitedEvents']);

        Route::middleware('authRole:' . Role::MEG)->group(function () {
            Route::post('/add', [EventController::class, 'add']);
            Route::post('/update/{event}', [EventController::class, 'update']);
            Route::post('/update-invited/{event}', [EventController::class, 'updateInvitePositions']);
            Route::post('/delete/{eventID}', [EventController::class, 'delete']);

            Route::get('/preview-certificate/{event}', [EventController::class, 'certificateSample'])->name('preview.certificate');

            Route::post('/send-for-certificate-signing/{eventID}', [EventController::class, 'sendCertificateForSigning']);
            Route::post('/sign-certificate/{eventID}', [EventController::class, 'signCertificate']);
            Route::post('/send-certificates/{eventID}', [EventController::class, 'sendCertificates']);

        });
        Route::middleware('authRole:' . Role::MEG . ',' . Role::FSD)->group(function () {
            Route::get('/registrations/{event}', [EventController::class, 'eventRegistrations']);
            Route::post('/registration-update-status/{eventReg}', [EventController::class, 'approveEventRegistration']);
        });

        Route::middleware('authRole:' . Role::ARAUTHORISER . ',' . Role::ARINPUTTER)->group(function () {
            Route::post('/register/{event}', [EventController::class, 'register']);
            Route::post('/update-pop/{eventReg}', [EventController::class, 'registerUpdatePOP']);
        });
    });
    //
    Route::group(['prefix' => 'fees-and-dues'], function () {
        Route::get('/current', [FeesAndDuesController::class, 'listCurrent']);
    });
    //
    Route::group(['prefix' => 'applicant-guide'], function () {
        Route::get('/current', [ApplicantGuidesController::class, 'listCurrent']);
    });
    //
    Route::group(['prefix' => 'member-guide'], function () {
        Route::get('/current', [MemberGuidesController::class, 'listCurrent']);
    });

    // Notification of change
    Route::group(['prefix' => 'change-request'], function () {

        Route::middleware('authRole:' . Role::ARINPUTTER)->group(function () {
            Route::post('/send', [NotificationOfChangeController::class, 'send']);
            Route::post('/ar-comment', [NotificationOfChangeController::class, 'comment']);
        });

        Route::middleware('authRole:' . Role::ARAUTHORISER)->group(function () {
            Route::post('/update-status', [NotificationOfChangeController::class, 'updateStatus']);
        });

        Route::middleware('authRole:' . Role::ARAUTHORISER . ',' . Role::ARINPUTTER)->group(function () {
            Route::get('/ar-list', [NotificationOfChangeController::class, 'arList']);
        });

        Route::middleware('authRole:' . Role::MEG)->group(function () {
            Route::get('/list', [NotificationOfChangeController::class, 'list']);
            Route::post('/meg-comment', [NotificationOfChangeController::class, 'comment']);
            Route::post('/meg-update-status', [NotificationOfChangeController::class, 'megUpdateStatus']);
        });

    });

});

Route::get('execute-commands', [SystemController::class, 'executeCommands'])->name('executeCommands');
Route::get('clear-model/{model}', [SystemController::class, 'clearModel'])->name('clearModel');
Route::get('refresh-database', [SystemController::class, 'refreshDatabase'])->name('refreshDatabase');
Route::get('storage-link', [SystemController::class, 'linkStorage'])->name('linkStorage');

Route::get('cert-sample/{event}', [EventController::class, 'certificateSample'])->name('previewCertificate');
Route::get('cert-sample-download/{event}', [EventController::class, 'certificateSampleDownload'])->name('previewCertificateDownload');
Route::get('report-download/{data}', [SystemController::class, 'report'])->name('downloadReport');

Route::group(['prefix' => 'webhook'], function () {
    Route::group(['prefix' => 'qpay/payment'], function () {
        Route::post('/success', [QpayController::class, 'success']);
        Route::post('/fail', [QpayController::class, 'fail']);
        Route::post('/careless', [QpayController::class, 'careless']);
    });
});

Route::group(['prefix' => 'general'], function () {
    Route::get('/fmdq-systems', [GeneralController::class, 'fmdqSystems']);
});

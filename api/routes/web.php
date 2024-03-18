<?php

use App\Helpers\ESuccessLetter;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MembershipApplicationController;
use App\Http\Controllers\QpayController;
use App\Http\Controllers\SystemController;
use App\Models\Application;
use App\Models\User;
use App\Notifications\InfoNotification;
// use Dompdf\Dompdf;
use Illuminate\Support\Facades\Mail;
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
    return view('welcome');
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
    // dd($content);
    // $pdf = PDF::loadView('success.dmb-letter', $content);

    // $pdfC = view('success.e-letter', compact('content'));

    // $dompdf = new Dompdf();
    // $dompdf->loadHTML($pdfC);
    // $dompdf->render();
    // $pdfdata = $dompdf->output();
    // dd(base64_decode($application->e_success_letter));
    $data["email"] = "testing@gmail.com";
    $data["title"] = "From test.com";
    $data["body"] = "This is Demo";
    Mail::send('mails.test', $data, function ($message) use ($data, $application) {
        $message->to($data["email"], $data["email"])
            ->subject($data["title"])
            ->attachData(base64_decode($application->e_success_letter), 'e-success.pdf', [
                'as' => 'e-success.pdf',
                'mime' => 'application/pdf',
            ]);
    });

    return view('success.e-letter', compact('content'));
// return view('success.letter');
// return view('success.letter');

});

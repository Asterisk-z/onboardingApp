<?php

namespace App\Jobs;

use App\Helpers\MailContents;
use App\Helpers\Utility;
use App\Models\Application;
use App\Models\Invoice;
use App\Models\ProofOfPayment;
use App\Models\Role;
use App\Notifications\InfoNotification;
use Carbon\Carbon;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;

class SendSuccessfulPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $ipAddress;
    protected $paperSize;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data, $ipAddress)
    {
        $this->data = $data;
        $this->ipAddress = $ipAddress;
        $this->paperSize = array(0, 0, 800, 480);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invoice = Invoice::where('reference', $this->data['newRef'])->first();
        $application = Application::where('invoice_id', $invoice->id)->first();
        $user = $application->applicant;

        if (
            $application->currentStatus() != Application::statuses['CG'] &&
            $application->currentStatus() != Application::statuses['CNG'] &&
            $application->currentStatus() != Application::statuses['FDP'] &&
            $application->currentStatus() != Application::statuses['MDP']
        ) {
            logger("Unable to complete your request at this point: Status mismatch.");
            return;
        }

        if ($invoice->is_paid) {
            logger("Unable to complete your request at this point: Invoice already paid for.");
            return;
        }

        //Generate proof of payment

        $date = Carbon::now()->format('YmdHis');

        $fileName = "online_proof_of_payment_" . $invoice->id . $date . ".pdf";
        $pathPipe = 'proof_of_payment/online';
        $pathName = str_contains(config('app.storage_path'), 'app/public') ? 'app/public' : '';
        $path = storage_path("{$pathName}/{$pathPipe}");
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $filepath = "$path/$fileName";
        $publicPath = config("app.url") . "/" . config('app.storage_path') . "{$pathPipe}/" . $fileName;
        $name = "proof_of_payment_$date.pdf";

        $proof = ProofOfPayment::create([
            'proof' => "{$pathPipe}/{$fileName}",
        ]);

        $application->proof_of_payment = $proof->id;
        $application->save();

        $application->proof_of_payment()->save($proof);
        $dateTime = new DateTime(now());

        $data = [
            'amount' => number_format(Utility::getTotalFromInvoice($invoice)),
            'payee' => "{$user->first_name} {$user->last_name} {$user->middle_name}",
            'date' => $dateTime->format('M. j, Y'),
            'reference' => $invoice->reference,
            'download_link' => $publicPath,
            'name' => $name,
        ];

        $pdf = App::make('dompdf.wrapper');

        $isDownload = true;

        $pdf->loadView('mails.payment-proof', compact('data', 'isDownload'))->setPaper($this->paperSize);

        $pdf->save($filepath);

        Utility::applicationStatusHelper($application, Application::statuses['PPU'], Application::office['AP'], Application::office['FSD']);
        Utility::applicationTimestamp($application, 'AMP');

        logAction($user->email, 'Proof of payment uploaded', "Applicant successfully uploaded proof of payment.", $this->ipAddress);

        $MBGs = Utility::getUsersEmailByCategory(Role::MBG);
        $MEGs = Utility::getUsersEmailByCategory(Role::MEG);
        $FSDs = Utility::getUsersByCategory(Role::FSD);
        $CCs = array_merge($MBGs, $MEGs);

        $attachment = [
            [
                'saved_path' => $publicPath,
                'name' => $name,
            ],
        ];

        $companyName = getApplicationFieldValue($user, $application, 'companyName');
        $applicationType = applicationType($application);
        Notification::send($FSDs, new InfoNotification(MailContents::paymentMail($companyName), MailContents::paymentSubject($applicationType), $CCs, $attachment));

    }
}

<?php

namespace App\Jobs;

use App\Models\Education\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class GenerateAndSendCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $requestedIDs;
    private $certPaperSize = array(0, 0, 800, 480);
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $requestedIDs, $certPaperSize = null)
    {
        $this->requestedIDs = $requestedIDs;

        if ($certPaperSize) {
            $this->certPaperSize = $certPaperSize;
        }

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // mark the event as attended.
        EventRegistration::whereIn('id', $this->requestedIDs)->update(['attended' => 1]);

        $eventRegs = EventRegistration::with('user', 'event')->whereIn('id', $this->requestedIDs)->where('is_del', 0)->get();

        $isDownload = true;

        foreach ($eventRegs as $eventReg) {
            // generate certificate
            $name = $eventReg->user->getFullNameAttribute();
            $event = $eventReg->event;
            $eventName = $eventReg->event->name;
            $eventDate = $eventReg->event->date;
            $filePath = "certificate_" . $eventReg->id . ".pdf";

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('mails.certificate', compact('event', 'name', 'isDownload'))->setPaper($this->certPaperSize);

            $pdf->save($eventReg->getCertificateFullPath($filePath));

            $eventReg->certificate_path = $filePath;
            $eventReg->save();

            // send the certificate
            SendGeneratedCertificateJob::dispatch($eventReg);
<<<<<<< HEAD
=======

>>>>>>> 9d9b8f1f27c00615f6303d38447ac96c8dd6ed20
        }

        logger("Certificates generated for: " . json_encode($this->requestedIDs));
    }
}

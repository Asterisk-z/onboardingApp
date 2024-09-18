<?php

namespace App\Jobs;

use App\Helpers\EventNotificationUtility;
use App\Models\Education\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendGeneratedCertificateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $eventReg;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EventRegistration $eventReg)
    {
        $this->eventReg = $eventReg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $id = $this->eventReg->id;
        if (!$this->eventReg->certificate_path) {
            // logger("Cannot send certificate. Cert path not specified ($id)");
            return;
        }

        EventNotificationUtility::certificate($this->eventReg);
        $this->eventReg->certificate_sent = true;
        $this->eventReg->save();
    }
}

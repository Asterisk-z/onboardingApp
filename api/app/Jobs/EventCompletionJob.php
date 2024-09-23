<?php

namespace App\Jobs;

use App\Mail\EventCerticateMail;
use App\Models\Education\EventRegistration;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EventCompletionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $eventReg;
    protected $emailData;
    protected $cc;
    protected $attachment;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EventRegistration $eventReg, $emailData, $cc = [], $attachment = [])
    {

        $this->eventReg = $eventReg;
        $this->emailData = $emailData;
        $this->cc = $cc;
        $this->attachment = $attachment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Mail::to([$this->eventReg->user->email])
            ->cc($this->cc)
            ->send(new EventCerticateMail($this->emailData, $this->attachment));

    }
}

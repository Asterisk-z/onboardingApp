<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = [];
        $info = $this->data['content'];
        $subject = $this->data['subject'];
        $displayName = $this->data['name'] ?? 'Team';

        return $this->view('mails.info', compact('user', 'info', 'displayName'))
                ->subject($subject);
    }
}

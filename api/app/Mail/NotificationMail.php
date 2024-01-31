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
    protected $attachment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $attachment = [])
    {
        $this->data = $data;
        $this->attachment = $attachment;
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

        $mail = $this->view('mails.info', compact('user', 'info', 'displayName'))->subject($subject);

        if($this->attachment){
            foreach ($this->attachment as $attachment) {
                $mail = $mail->attach($attachment['saved_path'], [
                    'as' => $attachment['name'],
                ]);
            }
        }

        return $mail;
        
    }
}


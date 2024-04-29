<?php

namespace App\Mail;

use App\Helpers\ESuccessLetter;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FinalApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    protected $application;
    protected $attachment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, Application $application, $attachment = [])
    {
        $this->data = $data;
        $this->application = $application;
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

        //$content = ESuccessLetter::generate($this->application);
        if ($this->attachment) {
            foreach ($this->attachment as $attachment) {
                $mail->attach($attachment['saved_path'], ['as' => $attachment['name'], 'mime' => 'application/pdf']);
            }
        }

        // $mail->attachData($content, 'e-success.pdf', [
        //     'as' => 'e-success.pdf',
        //     'mime' => 'application/pdf',
        // ]);

        return $mail;

    }
}

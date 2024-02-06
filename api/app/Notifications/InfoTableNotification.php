<?php

namespace App\Notifications;

use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InfoTableNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $data;
    protected $attachment;
    protected $subject;
    protected $cc;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $subject = "Info", $data = [], $cc = [], $attachment = [])
    {
        $this->message = $message;
        $this->subject = $subject;
        $this->cc = $cc;
        $this->attachment = $attachment;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $user = $notifiable;
        $info = $this->message;
        $data = $this->data;
        $subject = $this->subject ?? '';
        $displayName = $user->first_name;

        $mail = (new MailMessage)
            ->subject(config('app.name') . " - " . $subject)
            ->view('mails.info-table', compact('info', 'data'));

        if ($this->cc) {
            $mail = $mail->cc($this->cc);
        }

        if ($this->attachment) {
            $mail = $mail->attach($this->attachment['saved_path'], [
                'as' => $this->attachment['name'],
            ]);
        }

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

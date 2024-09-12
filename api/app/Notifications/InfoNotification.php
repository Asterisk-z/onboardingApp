<?php

namespace App\Notifications;

use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InfoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;
    protected $attachment;
    protected $subject;
    protected $cc;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $subject = "Info", $cc = [], $attachment = [])
    {
        $this->message = $message;
        $this->subject = $subject;
        $this->cc = $cc;
        $this->attachment = $attachment;
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
        $subject = $this->subject ?? '';
        $displayName = $user->last_name && $user->first_name ? $user->last_name . " " . $user->first_name : '';

        if ($subject == 'New Membership Signup' || $subject == 'Payment Rejected by MBG' || $subject == 'MROIS Document Upload' || $subject == 'Profiling Request:' || $subject == 'Profiling Request' || str_contains($subject, "Update of") || str_contains($subject, "Email Group Update for")) {
            $displayName = "Team";
        } else {
            if ($user->role_id == Role::MSG) {
                $displayName = "MSG";
            }

            if ($user->role_id == Role::MEG) {
                $displayName = "MEG";
            }

            if ($user->role_id == Role::FSD) {
                $displayName = "FSD";
            }

            if ($user->role_id == Role::MBG) {
                $displayName = "MBG";
            }

            if ($user->role_id == Role::BLG) {
                $displayName = "RLG";
            }

            if ($user->role_id == Role::HELPDESK) {
                $displayName = "HELP DESK";
            }
        }

        $mail = (new MailMessage)
            ->subject(config('app.name') . " - " . $subject)
            ->view('mails.info', compact('user', 'info', 'displayName'));

        if ($this->cc) {
            $mail = $mail->cc($this->cc);
        }

        if ($this->attachment) {
            logger('$this->attachment');
            logger($this->attachment);
            if (in_array("saved_path", $this->attachment) && in_array("name", $this->attachment)) {
                $mail = $mail->attach($this->attachment['saved_path'], [
                    'as' => $this->attachment['name'],
                ]);
            } else {
                foreach ($this->attachment as $attachment) {
                    if (in_array("saved_path", $attachment) && in_array("name", $attachment)) {
                        $mail = $mail->attach($attachment['saved_path'], [
                            'as' => $attachment['name'],
                        ]);
                    }
                }
            }

        }

        $displayName = null;

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

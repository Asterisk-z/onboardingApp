<?php

namespace App\Console\Commands;

use App\Helpers\EventNotificationUtility;
use App\Models\Education\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Log;


class SendEventRemindersByFrequency extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:send-freq-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for upcoming events based on the frequency';

    protected $message = [];
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // today or future events
        $events = Event::where('date', '>=', now()->toDateString())->get();


        foreach ($events as $event) {
            $currentDate = now()->format('Y-m-d');

            // send registered AR reminder based on frequency
            switch ($event->registered_remainder_frequency) {
                case 'Daily':
                    $this->sendRegisteredReminderIfDue($event, $currentDate, 1);
                    break;
                case 'Weekly':
                    $this->sendRegisteredReminderIfDue($event, $currentDate, 7);
                    break;
                case 'Monthly':
                    $this->sendRegisteredReminderIfDue($event, $currentDate, 30);
                    break;
                default:
                    $this->message[] = "No valid registered frequency";
                    break;
            }


            // send unregistered AR reminder based on frequency
            switch ($event->unregistered_remainder_frequency) {
                case 'Daily':
                    $this->sendUnRegisteredReminderIfDue($event, $currentDate, 1);
                    break;
                case 'Weekly':
                    $this->sendUnRegisteredReminderIfDue($event, $currentDate, 7);
                    break;
                case 'Monthly':
                    $this->sendUnRegisteredReminderIfDue($event, $currentDate, 30);
                    break;
                default:
                    $this->message[] = "No valid unregistered frequency";
                    break;
            }
        }



        // $this->log([
        //     'events_count' => count($events),
        //     'registered_frequency' => $event->registered_remainder_frequency,
        //     'unregistered_frequency' => $event->unregistered_remainder_frequency,
        //     'message' => $this->message,
        // ]);


        return 0;
    }

    private function sendRegisteredReminderIfDue($event, $currentDate, $interval)
    {
        $lastReminderDate = Carbon::parse($event->created_at); // assume the last reminder was on the created date
        if ($event->last_reminder_date) {
            $lastReminderDate = Carbon::parse($event->last_reminder_date);
        }

        $nextReminderDate = $lastReminderDate->addDays($interval)->format('Y-m-d');

        if ($nextReminderDate <= $currentDate) {

            // Update last and next reminder dates
            $event->update([
                'last_reminder_date' => $currentDate,
            ]);

            // send the notifications
            EventNotificationUtility::reminderNotification($event);
        }
    }

    private function sendUnRegisteredReminderIfDue($event, $currentDate, $interval)
    {
        $lastReminderDate = Carbon::parse($event->created_at); // assume the last reminder was on the created date
        if ($event->last_reminder_date_non_registered) {
            $lastReminderDate = Carbon::parse($event->last_reminder_date_non_registered);
        }

        $nextReminderDate = $lastReminderDate->addDays($interval)->format('Y-m-d');

        if ($nextReminderDate <= $currentDate) {

            // Update last and next reminder dates
            $event->update([
                'last_reminder_date_non_registered' => $currentDate,
            ]);

            // send the notifications
            EventNotificationUtility::inviteNotification($event);
        }
    }


    private function log(array $data)
    {
        try {
            Log::channel('command_freq_remainder')->info(json_encode($data));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}


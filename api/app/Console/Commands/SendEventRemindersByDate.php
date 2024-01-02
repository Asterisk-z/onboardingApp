<?php

namespace App\Console\Commands;

use App\Helpers\EventNotificationUtility;
use App\Models\Education\Event;
use App\Models\Education\EventNotificationDates;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Log;


class SendEventRemindersByDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event:send-date-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for upcoming events based on the dates specified';

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
        $dates = EventNotificationDates::with('event')->where('reminder_date', '=', now()->toDateString())->whereNull('sent_on')->get();

        $registered_count = $unregistered_count = 0;

        foreach ($dates as $item) {
            $event = $item->event;

            if ($item->type == 'Registered') {
                // notify registered
                EventNotificationUtility::reminderNotification($event);
                $registered_count++;
            } else {
                // notify unregistered
                EventNotificationUtility::inviteNotification($event);
                $unregistered_count++;
            }

            $item->update([
                'sent_on' => now(),
            ]);
        }



        $this->log([
            'dates_count' => count($dates),
            'registered_count' => $registered_count,
            'unregistered_count' => $unregistered_count,
        ]);

        return 0;
    }




    private function log(array $data)
    {
        try {
            Log::channel('command_date_remainder')->info(json_encode($data));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}


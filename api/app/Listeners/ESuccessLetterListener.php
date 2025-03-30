<?php
namespace App\Listeners;

use App\Events\ApplicationSubmissionEvent;
use App\Events\ESuccessLetterEvent;
use App\Helpers\ESuccessLetter;
use App\Helpers\InvoiceGenerator;
use App\Helpers\Utility;
use App\Models\Application;
use App\Models\ApplicationField;
use App\Models\Invoice;
use App\Models\InvoiceContent;
use App\Models\MemberESuccessLetter;
use App\Models\MonthlyDiscount;
use App\Models\Role;
use App\Models\SystemSetting;
use App\Models\MembershipCategory;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;

class ESuccessLetterListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ESuccessLetterEvent  $event
     * @return void
     */
    public function handle(ESuccessLetterEvent $event)
    {
        $letter = $event->letter;

        $application = Application::where('id', $letter->application_id)->first();

        $data = Application::where('applications.id', $application->id);
        $data = Utility::applicationDetails($data);
        $data = $data->first();

        (new ESuccessLetter())->generate($application, true);

    }

}

<?php
namespace App\Listeners;

use App\Events\MembershipAgreementLetterEvent;
use App\Models\Application;
use App\Models\MemberAgreement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;
use PDF;

class MembershipAgreementLetterListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\MembershipAgreementLetterEvent  $event
     * @return void
     */
    public function handle(MembershipAgreementLetterEvent $event)
    {

        $agreement = $event->agreement;

        $application = Application::where('id', $agreement->id)->first();

        $membershipCategory = $application->membershipCategory;

        if (! $details = MemberAgreement::where('application_id', $application->id)->first()) {
            return "error";
        }

        $pdf = PDF::loadView('agreement.' . $membershipCategory->code, compact('details'));
        Storage::put('public/agreement/e_membership_agreement' . $application->id . '.pdf', $pdf->output());
        $application->membership_agreement = 'agreement/e_membership_agreement' . $application->id . '.pdf';
        $application->save();

    }

}

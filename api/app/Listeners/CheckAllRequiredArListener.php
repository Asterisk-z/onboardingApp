<?php

namespace App\Listeners;

use App\Events\ArAddedEvent;
use App\Jobs\FinalApplicationProcessingJob;
use App\Models\Application;
use App\Models\Institution;
use App\Models\MembershipCategoryPostition;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckAllRequiredArListener implements ShouldQueue
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
     * @param  \App\Events\ArAddedEvent  $event
     * @return void
     */
    public function handle(ArAddedEvent $event)
    {
        $newAr = $event->newAr;

        $institutionId = $event->institutionId;
        $institution = Institution::find($institutionId);
        $application = Application::where('institution_id', $institutionId)->first();

        $membershipCategory = $institution->membershipCategories->first();
        $compulsoryPositions = $membershipCategory->positions()->where('is_compulsory', 1)->pluck('position_id')->toArray();
        $uploadedPositions = User::where('institution_id', $institutionId)->pluck('position_id')->toArray();
        $missingPositions = array_diff($compulsoryPositions, $uploadedPositions);

        if(empty($missingPositions)){
            $application->all_ar_uploaded = 1;
            $application->save();

            if($application->completed_at){
                if(in_array($newAr->position_id, $compulsoryPositions)){
                    //TODO::send to helpdesk
                }
            }

            FinalApplicationProcessingJob::dispatch($application->id);
        }
    }
}

<?php

namespace App\Listeners;

use App\Events\ArAddedEvent;
use App\Helpers\Utility;
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
        $arPosition = $newAr->position_id;

        $institutionId = $event->institutionId;        
        $userCompulsoryCategory = MembershipCategoryPostition::where('position_id', $arPosition)->where('is_compulsory', 1)->pluck('category_id')->toArray();
        $applications = Application::where('institution_id', $institutionId)->whereNotNull('completed_at')->whereIn('membership_category_id', $userCompulsoryCategory)->get();

        foreach ($applications as $application) {
            $membershipCategory = $application->membershipCategory;
            $compulsoryPositions = $membershipCategory->positions()->where('is_compulsory', 1)->pluck('position_id')->toArray();
            $uploadedPositions = User::where('institution_id', $institutionId)->pluck('position_id')->toArray();
            $missingPositions = array_diff($compulsoryPositions, $uploadedPositions);

            if (empty($missingPositions)) {
                $application->all_ar_uploaded = 1;
                $application->save();
            }

            if (in_array($arPosition, $compulsoryPositions)) {
                Utility::sendMailGroupNotification([$newAr], $membershipCategory);
            }
        }
    }
}

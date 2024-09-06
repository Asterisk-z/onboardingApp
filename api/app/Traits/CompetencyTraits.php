<?php

namespace App\Traits;

use App\Models\Competency;
use App\Models\CompetencyFramework;
use App\Models\Position;
use App\Models\PositionGroup;
use App\Models\User;

trait CompetencyTraits
{

    public function arPercentageCoverage(User $user)
    {
        $totalCompetencies = CompetencyFramework::where('is_del', 0)->where('position', $user->position->position_group_id)->count();
        $totalCompliedCompetencies = Competency::where('ar_id', $user->id)->count();
        return number_format((($totalCompliedCompetencies / $totalCompetencies) * 100), 2) . "%";
    }

    public function arPercentageCoverageForCompetency($competencyId, PositionGroup $position)
    {

        $position_ids = Position::where('position_group_id', $position->id)->pluck('id');
        $totalArs = User::where('is_del', 0)->whereIn('position_id', $position_ids)->count();
        $totalCompliedCompetencies = Competency::where('framework_id', $competencyId)->count();

        return $totalArs > 0 ? number_format((($totalCompliedCompetencies / $totalArs) * 100), 2) . "%" : '0%';
    }

}

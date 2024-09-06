<?php

namespace App\Http\Resources;

use App\Traits\CompetencyTraits;
use Illuminate\Http\Resources\Json\JsonResource;

class CompetencyFrameworkResource extends JsonResource
{
    use CompetencyTraits;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'active' => $this->active,
            'category_obj' => $this->category_obj,
            'position_group_obj' => $this->position_group_obj,
            'position_obj' => $this->position_obj,
            'proficiencies' => $this->proficiencies,
            'ar_response' => $this->ar_response,
            'created_at' => $this->created_at,
            'arPercentage' => $this->arPercentageCoverageForCompetency($this->id, $this->position_group_obj),
        ];

    }
}

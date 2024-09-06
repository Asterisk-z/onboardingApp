<?php

namespace App\Http\Resources;

use App\Traits\CompetencyTraits;
use Illuminate\Http\Resources\Json\JsonResource;

class CompetencyFrameworkARResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'institution' => $this->institution,
            'role' => $this->role,
            'position' => $this->position,
            'reg_id' => $this->reg_id,
            'created_at' => $this->created_at,
            'competency_response' => $this->competency_response,
            'arPercentage' => $this->arPercentageCoverage($this->resource),
        ];
    }
}

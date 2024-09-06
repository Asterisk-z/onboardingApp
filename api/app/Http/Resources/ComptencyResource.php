<?php

namespace App\Http\Resources;

use App\Traits\CompetencyTraits;
use Illuminate\Http\Resources\Json\JsonResource;

class ComptencyResource extends JsonResource
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
            'cco' => $this->cco,
            'ar' => $this->ar,
            'institution' => $this->ar->institution,
            'ar_id' => $this->ar_id,
            'cco_id' => $this->cco_id,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'evidence_file' => $this->evidence_file,
            'physical_file' => $this->physical_file,
            'framework_id' => $this->framework_id,
            'framework' => $this->framework,
            'institution_id' => $this->institution_id,
            'is_competent' => $this->is_competent,
            'status' => $this->status,
            'arPercentage' => $this->arPercentageCoverage($this->ar),
        ];

    }
}

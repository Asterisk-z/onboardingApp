<?php

namespace App\Http\Resources;

use App\Traits\UserTraits;
use Illuminate\Http\Resources\Json\JsonResource;

class SanctionResource extends JsonResource
{
    use UserTraits;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ar' => $this->ar,
            'ar_summary' => $this->ar_summary,
            'sanction_summary' => $this->sanction_summary,
            'evidence' => $this->evidence,
            'created_by' => $this->created_by,
            'institution' => $this->institution,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'institution_obj' => $this->institution_obj,
            'sanctioner' => $this->returnValue($this->sanctioner),
            'sanctionee' => $this->returnValue($this->sanctionee),
            'evidence_file' => $this->evidence_file,
        ];
    }
}

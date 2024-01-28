<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "internal" => [
                "application_id" => $this->application_id,
                "institution_id" => $this->institution_id,
                "concession_stage" => $this->concession_stage,
                "amount_received_by_fsd" => $this->amount_received_by_fsd,
                "mbg_review_stage" => $this->mbg_review_stage,
                "meg_review_stage" => $this->meg_review_stage,
                "meg2_review_stage" => $this->meg2_review_stage,
                "fsd_review_stage" => $this->fsd_review_stage,
                "category_id" => $this->category_id,
                "category_name" => $this->category_name
            ],
            "basic" => [
                "company_name" => $this->company_name,
                "company_email" => $this->company_email,
                "company_name" => $this->company_name,
            ]
        ];
    }
}

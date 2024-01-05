<?php

namespace App\Http\Resources\Education;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventBasicResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'time' => $this->time,
            'is_annual' => $this->is_annual,
            'fee' => $this->fee,

            'image' => $this->image,
            'image_url' => $this->image ? config('app.url') .'/storage/app/public/'.$this->image : null, // Adjust the path based on your storage setup
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'created_by' => ($this->createdBy != null) ? $this->createdBy->getBasicData() : null,

            'registrations_count' => $this->registrations_count,

        ];
    }
}

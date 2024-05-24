<?php

namespace App\Http\Resources;

use App\Traits\ApplicationTraits;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationChildFieldResource extends JsonResource
{
    use ApplicationTraits;
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
            'category' => $this->category,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'required' => $this->required,
            'page' => $this->page,
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at,
            'field_options' => $this->field_options,
            'field_value' => $this->childApplicationFieldValues($this->id),
            // 'terere' => 'ferferf',
        ];

    }
}

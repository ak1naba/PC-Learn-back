<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MaterialResource extends JsonResource
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
            "id"=>$this->id,
            "lesson_id"=>$this->lesson_id,
            "part_img"=>Storage::url($this->part_img),
            "relative_element"=>$this->relative_element,
            "position_x"=>$this->position_x,
            "position_y"=>$this->position_y,

            "state"=>StateResource::collection($this->whenLoaded('state'))
        ];
    }
}

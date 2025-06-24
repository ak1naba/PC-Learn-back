<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            "url_title"=>$this->url_title,
            "title"=>$this->title,
            "theory"=>$this->theory,
            "type_lesson_id"=>$this->type_lesson_id,
            "hard_binding"=>$this->hard_binding,

            "materials"=> MaterialResource::collection($this->whenLoaded('materials'))
        ];
    }
}

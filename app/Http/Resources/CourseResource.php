<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends BaseResource
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
            'id'=>$this->id,
            'course_code'=>$this->course_code,
            'name'=>$this->name,
            'year_of_course'=>$this->year_of_course,
            'semester'=>$this->semester,
            'specialization'=>$this->specialization,
            'IsActive'=>$this->IsActive
            ];
    }
}

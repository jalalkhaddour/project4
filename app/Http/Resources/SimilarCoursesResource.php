<?php

namespace App\Http\Resources;

use Faker\Provider\Base;
use Illuminate\Http\Resources\Json\JsonResource;

class SimilarCoursesResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}

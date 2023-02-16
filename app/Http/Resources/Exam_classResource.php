<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Exam_classResource extends BaseResource
{
public function toArray($request)
{
    return [
        'id'=>$this->id,
        'name'=>$this->name,
        'capacity'=>$this->capacity,

    ];
}}

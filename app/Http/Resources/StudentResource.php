<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends BaseResource
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
            'fullname'=>$this->fullname,
            'fathername'=>$this->fathername,
            'mothername'=>$this->mothername,
            'birthplace'=>$this->birthplace,
            'birthdate'=>$this->birthdate,
            'gender'=>$this->gender,
            'place_num_registration'=>$this->place_num_registration,
            'nationality'=>$this->nationality,
            'address'=>$this->address,
            'phone'=>$this->phone,
            'recruitment_division'=>$this->recruitment_division,
            'national_num'=>$this->national_num,
            'homephone'=>$this->homephone,
            'university_num'=>$this->university_num,
            'certifeca'=>$this->certifeca,
            'specialization'=>$this->specialization

        ];
    }
}

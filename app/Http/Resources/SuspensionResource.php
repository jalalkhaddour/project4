<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SuspensionResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

    {
        return [
            'suspension_year'=>$this->suspension_year,
            'suspension_semester'=>$this->suspension_semester,
            'reg_receipt_num'=>$this->suspension_semester,
            'reg_receipt_date'=>$this->reg_receipt_date,
            'counter'=>$this->counter
        ];
    }

    }
}

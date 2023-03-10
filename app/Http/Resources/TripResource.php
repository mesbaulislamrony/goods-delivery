<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'from' => $this->from,
            'to' => $this->to,
            'type' => $this->type,
            'status' => $this->status,
            'date' => $this->date,
            'amount' => $this->amount,
            'goods' => UserTripGoodsResource::collection($this->goods),
            'transporter' => new TransporterResource($this->transporter),
        ];
    }
}

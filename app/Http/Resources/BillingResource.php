<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'transporter' => new TransporterResource($this->transporter),
            'total' => $this->amount,
        ];
    }
}

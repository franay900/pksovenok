<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PeriodResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'period_type_id' => $this->period_type_id,
            'year_id' => $this->year_id,
            'organization_id' => $this->organization_id,
            'begin' => $this->begin,
            'end' => $this->end,
            'number' => $this->number,
            'name' => $this->number . ' ' . $this->periodType->name
        ];
    }
}

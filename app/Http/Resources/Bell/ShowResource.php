<?php

namespace App\Http\Resources\Bell;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'day'=> $this->day,
            'number' => $this->number,
            'begin' => $this->begin,
            'id' => $this->end
        ];
    }
}

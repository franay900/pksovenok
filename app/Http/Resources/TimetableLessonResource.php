<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimetableLessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'load_id' => $this->load_id,
            'day' => $this->day,
            'number' => $this->number,
            'timetable_id' => $this->timetable_id,

        ];
    }
}

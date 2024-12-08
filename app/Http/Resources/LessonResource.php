<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'load_id' => $this->load_id,
            'date' => $this->date,
            'number' => $this->number,
            'teacher_id' => $this->teacher_id,
            'group_id' => $this->group_id,
        ];
    }
}

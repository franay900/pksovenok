<?php

namespace App\Http\Resources\Load;

use App\Http\Resources\SubjectResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoadResource extends JsonResource
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
            'group_id' => $this->group_id,
            'subgroup_id' => $this->subgroup_id,
            'subject_id' => $this->subject_id,
            'subject_name' => $this->subject->name . ($this->subgroup ? ' (' . $this->subgroup->name . ')' : ''),
            'teacher' => User::find($this->teacher_id),
        ];
    }
}

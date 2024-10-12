<?php

namespace App\Http\Resources\Group;

use App\Models\Bell;
use App\Models\User;
use App\Models\PeriodType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'number' => $this->number,
            'letter' => $this->letter,
            'bell' => Bell::find($this->bell_id),
            'manager' => User::find($this->manager_id),
            'period' => PeriodType::find($this->period_type_id)
        ];
    }
}

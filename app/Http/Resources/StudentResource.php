<?php

namespace App\Http\Resources;

use App\Http\Resources\Group\GroupResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'user' => new UserResource($this->user),
            'group' => new GroupResource($this->group),
        ];
    }
}

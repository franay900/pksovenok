<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
            'username' => $this->username,
            'birthday' => $this->birthday,
            'roles' => $this->roles->map(function ($role) {
                // Возвращаем новый массив без поля pivot
                return [
                    'id' => $role->id,
                    'created_at' => $role->created_at,
                    'updated_at' => $role->updated_at,
                    'name' => $role->name,
                    'key' => $role->key,
                ];
                
            }),
        ];
        
    }
}

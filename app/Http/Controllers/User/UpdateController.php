<?php

namespace App\Http\Controllers\user;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request, User $user)
    {

        $data = $request->validated();
        $user->update($data);
        $roles = $data['roles'];
        $roles = Arr::pluck($roles, 'key');
        $rolesFromDatabase = Role::whereIn('key', $roles)->get();
        $user->roles()->sync($rolesFromDatabase);
        return response()->json(['ok']);
    }
}

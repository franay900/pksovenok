<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\StoreRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class StoreController extends Controller
{

    public function __invoke(StoreRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $organizationId = $user->organization_id;
        $usernameExists = User::where('username', $request->username)->exists();
        if ($usernameExists){
            return response()->json([
                
                'username'    => 'Пользователь с таким логином уже существует',
              
            ], 422);
        }
        $data = $request->validated();
        $password = Str::random(8);
        $roles = $data['roles'];
        $user = User::create([
            'organization_id' => $organizationId,
            'name' => $data['name'],
            'surname' => $data['surname'],
            'patronymic' => $data['patronymic'],
            'username' => $data['username'],
            'password' => bcrypt($password)
        ]);

        
        $user->roles()->attach($roles);
        return response([$password]);
    }
}

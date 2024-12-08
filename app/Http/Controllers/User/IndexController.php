<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User\UserResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $organizationId = $user->organization_id;
        $users = User::where('organization_id', $organizationId)->get();
        return UserResource::collection($users);
    }

}

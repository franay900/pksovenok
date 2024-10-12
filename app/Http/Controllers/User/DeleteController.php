<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\DeleteRequest;
use App\Models\User;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function __invoke(DeleteRequest $request)
    {
        $ids = $request->validated()['ids'];
        $users = User::whereIn('id', $ids)->delete();
        return response([$users]);

    }
}

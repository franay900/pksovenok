<?php

namespace App\Http\Controllers;

use App\Http\Requests\Group\StoreRequest;
use App\Http\Resources\Group\GroupResource;
use App\Http\Resources\Load\LoadResource;
use App\Models\User;
use App\Models\Group;
use App\Models\Organization;
use App\Models\Period;
use App\Models\PeriodType;
use App\Services\GroupSerivce;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $service;
    public function __construct(GroupSerivce $groupSerivce)
    {
        $this->service = $groupSerivce;
    }

    public function index()
    {
        $user = auth()->user();

        return response()->json($this->service->index($user));


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $this->service->store($user, $request);
        return response()->json(['ok']);


    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        return new GroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        //
    }

    public function getGroupLoads(Group $group)
    {
        return LoadResource::collection($group->loads);
    }
}

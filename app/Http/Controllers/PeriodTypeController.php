<?php

namespace App\Http\Controllers;

use App\Http\Resources\PeriodResource;
use App\Models\Group;
use App\Models\Period;
use App\Models\PeriodType;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class PeriodTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return response()->json(PeriodType::all());
    }


    public function getPeriodTypesByGroup(Group $group)
    {


        return PeriodResource::collection($group->periods);
    }



}

<?php

namespace App\Http\Controllers;

use App\Models\Group;
use DateTime;
use DateTimeZone;
use App\Models\Period;
use App\Models\PeriodType;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Period\StoreRequest;

class PeriodController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $organizationId = $user->organization_id;

        return response()->json(Period::where('organization_id', $organizationId)->get());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $response = $this->service->store($request->validated());

        return response()->json($response);

    }

    /**
     * Display the specified resource.
     */
    public function show(Period $period)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Period $period)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Period $period)
    {
        //
    }


}

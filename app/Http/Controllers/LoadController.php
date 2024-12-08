<?php

namespace App\Http\Controllers;

use App\Http\Requests\Load\StoreRequest;
use App\Http\Resources\Load\LoadResource;
use App\Models\Load;
use App\Models\Group;
use App\Models\Subgroup;
use Illuminate\Http\Request;

class LoadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $existingLoad = Load::where('group_id', $data['group_id'])
        ->where('subgroup_id', $data['subgroup_id'])
        ->where('subject_id', $data['subject_id'])
        ->first();

        if ($existingLoad){
            $existingLoad->update(['teacher_id' => $data['teacher_id']]);
        }
        else {
            Load::create($data);
        };
        return response()->json($existingLoad);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $group)
    {

        $subgroups = Subgroup::where('group_id', $group)->get();
        $loads = Load::where('group_id', $group)->get();


        return response()->json([
            'subgroups' => $subgroups,
            'loads' => LoadResource::collection($loads)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Load $load)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Load $load)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Load $load)
    {
        //
    }
}

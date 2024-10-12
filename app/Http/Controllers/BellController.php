<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bell\StoreRequest;
use App\Http\Resources\Bell\BellResource;
use App\Models\Bell;
use App\Models\BellLesson;
use App\Models\Organization;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class BellController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $organizationId = $user->organization_id;
        $bells = Bell::where('organization_id', $organizationId)->get();
        return BellResource::collection($bells);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $user = JWTAuth::parseToken()->authenticate();
        $organizationId = $user->organization_id;
        $bell = Bell::create([

            'organization_id' => $organizationId,
            'name' => $data['name']
        ]);

        $bellId = $bell->id; 
        $lessons = Array();
        $dayCount = 0;
        $lessonCount = 0;
        foreach ($data['lessons'] as $day){
            $dayCount+=1;
            $lessonCount = 0;
            foreach($day as $lesson){
                $timePartsBegin = explode('T', $lesson['begin']);
                $timePartsEnd = explode('T', $lesson['end']);
                $lessonCount+=1;
                if(isset($timePartsBegin[1]))
                {
                    $timeBegin = date('H:i', strtotime($timePartsBegin[1]));
                    $timeEnd = date('H:i', strtotime($timePartsEnd[1]));
                    BellLesson::create([
                        'day' => $dayCount, 
                        'number' => $lessonCount,
                        'begin' => $timeBegin,
                        'end' => $timeEnd,
                        'bell_id' => $bellId,
                    ]);
                    $lessons[] = $dayCount;
                    $lessons[] = $timeBegin;
                   
                }
                
            }
        }
        return response($lessons);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bell $bell)
    {
        $bellId = $bell->id;
        $lessons = BellLesson::where('bell_id', $bellId)->get();
      
        return response()->json([
            'data' => [
                'name' => $bell->name, 
                'lessons' => $lessons
            ]
        ]); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bell $bell)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bell $bell)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bell $bell)
    {
        //
    }
}

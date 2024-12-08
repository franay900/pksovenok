<?php

namespace App\Http\Controllers;

use App\Http\Requests\Timetable\StoreRequest;
use App\Jobs\LessonCreateJob;
use App\Models\Organization;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $timetables = Timetable::where('organization_id', $user->organization_id)->get();
        $timetables = $timetables->map(function ($timetable) {
            $timetable->start = Carbon::parse($timetable->start)->locale('ru')->isoFormat('D MMMM Y');
            return $timetable;
        });
        return response()->json($timetables);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();
        $organization = Organization::find($user->organization_id);
        $timetable = Timetable::create([
            'organization_id' => $user->organization_id,
            'name' => $data['name'],
            'start' => Carbon::parse($data['start_date'])->tz('Europe/Moscow'),
            'year_id' => $organization->year_id,
        ]);

        return response()->json($timetable);
    }

    /**
     * Display the specified resource.
     */
    public function show(Timetable $timetable)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timetable $timetable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timetable $timetable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timetable $timetable)
    {
        //
    }
}

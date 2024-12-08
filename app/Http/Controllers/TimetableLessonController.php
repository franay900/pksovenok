<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimetableTemplate\StoreRequest;
use App\Http\Resources\TimetableLessonResource;
use App\Jobs\LessonCreateJob;
use App\Models\Organization;
use App\Models\Timetable;
use App\Models\TimetableLesson;
use App\Services\DateService;
use App\Services\TimetableService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TimetableLessonController extends Controller
{
    protected $service;
    public function __construct(TimetableService $service)
    {
        $this->service = $service;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Timetable $timetable)
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $result = $this->service->store($data);
            return response()->json($result, 201);
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($timetable)
    {
        $timetable = Timetable::find($timetable);
        $lessons = $timetable->lessons; // Предполагая, что у вас есть связь `lessons` в модели Timetable
        return TimetableLessonResource::collection($lessons);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimetableLesson $timetableLesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimetableLesson $timetableLesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimetableLesson $timetableLesson)
    {
        //
    }
}

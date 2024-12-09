<?php

namespace App\Http\Controllers;

use App\Http\Resources\LessonResource;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Load;
use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Ramsey\Collection\Collection;

class LessonController extends Controller
{

    public function index(int $groupId, int $loadId, Period $period): AnonymousResourceCollection
    {
        $lessons = Lesson::where('group_id', $groupId)
            ->where('load_id', $loadId)
            ->whereBetween('date', [
                Carbon::parse($period->begin), // Use Carbon::parse for better date handling
                Carbon::parse($period->end)
            ])
            ->get();
        return LessonResource::collection($lessons);
    }

}

<?php

namespace App\Services;

use App\Jobs\LessonCreateJob;
use App\Models\Organization;
use App\Models\Timetable;
use App\Models\TimetableLesson;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class TimetableService
{
    /**
     * Create a new class instance.
     */



    public function store(array $data)
    {
        $user = auth()->user();
        $organization = Organization::find($user->organization_id);

        $template = Timetable::find($data['timetable_id']);
        $dayOfWeek = (int)$data['day'];

        if ($dayOfWeek < 1 || $dayOfWeek > 7) {
            throw new \InvalidArgumentException('Неверный номер дня недели');
        }
        $timetableLesson = TimetableLesson::where('timetable_id', $data['timetable_id'])
            ->where('day', $dayOfWeek)
            ->where('number', $data['number'])
            ->where('group_id', $data['group_id'])
            ->first();
        if($timetableLesson){
            $timetableLesson->delete();
        }
        $lessons = TimetableLesson::create($data);

        $start = Carbon::parse($template->start);
        $end = Carbon::parse($organization->year['end']);

        LessonCreateJob::dispatch($start, $end, $dayOfWeek, $data);

        return $data;
    }
}

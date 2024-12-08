<?php

namespace App\Models;

use App\Services\DateService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimetableLesson extends Model
{
    use HasFactory;

    protected $guarded = false;


    public function timetable()
    {
        return $this->belongsTo(Timetable::class);
    }
    public function deleteLessons(DateService $dateService, $start, $end, $day)
    {
        $dates = $dateService->getDates($start, $end, $day);

        Lesson::where('number', $this->number)
            ->whereIn('date', $dates)
            ->where('load_id', $this->load_id)
            ->where('group_id', $this->group_id)
            ->delete();
    }

    protected static function booted()
    {
        static::deleting(function ($lesson) {
            $start = Carbon::parse($lesson->timetable->start);
            $end = Carbon::parse($lesson->timetable->end);
            $lesson->deleteLessons(app(DateService::class), $start, $end, $lesson->day);
        });
    }
}

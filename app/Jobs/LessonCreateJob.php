<?php

namespace App\Jobs;

use App\Models\Lesson;
use App\Models\Load;
use App\Models\TimetableLesson;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LessonCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $start;
    protected $end;
    protected $dayOfWeek;
    protected $data;

    public function __construct(Carbon $start, Carbon $end, int $dayOfWeek, array $data){
        $this->start = $start;
        $this->end = $end;
        $this->dayOfWeek = $dayOfWeek;
        $this->data = $data;
    }

    public function handle(): void
    {
        $dates = [];
        $currentDate = $this->start->copy();
        while ($currentDate <= $this->end) {
            if ($currentDate->dayOfWeekIso === $this->dayOfWeek) { // === для строгого сравнения
                $dates[] = $currentDate->toDateString();
            }
            $currentDate->addDay();
        }
        $load = Load::find($this->data['load_id']);
        foreach ($dates as $date) {
            Lesson::create([
                'load_id' => $this->data['load_id'],
                'date' => $date,
                'number' => $this->data['number'],
                'teacher_id' => $load->teacher_id,
                'group_id' => $load->group_id,
            ]);
        }
    }
}

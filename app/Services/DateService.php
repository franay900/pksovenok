<?php

namespace App\Services;

use Carbon\Carbon;
use InvalidArgumentException;

/*
 * Класс для получения дат в промежутке по дню недели.
 */
class DateService
{

    public function getDates($start, $end, $dayOfWeek)
    {
        $dates = [];

        while ($start <= $end) {
            if ($start->dayOfWeekIso === $dayOfWeek) { // === для строгого сравнения
                $dates[] = $start->toDateString();
            }
            $start->addDay();
        }

        return $dates;
    }
}


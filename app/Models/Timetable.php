<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory;
    protected $fillable = [
        'organization_id',
        'year_id',
        'start',
        'name'
    ];

    public function lessons()
    {
        return $this->hasMany(TimetableLesson::class);
    }
}

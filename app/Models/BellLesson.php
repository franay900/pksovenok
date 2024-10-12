<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BellLesson extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'begin', 'end', 'bell_id', 'day', 'number'];
}

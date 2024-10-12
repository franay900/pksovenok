<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'begin',
        'end',
        'year_id',
        'organization_id',
        'period_type_id',
        'number'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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


    public function periodType(): BelongsTo
    {
        return $this->belongsTo(PeriodType::class);
    }
}

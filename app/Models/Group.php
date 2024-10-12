<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'letter',
        'manager_id',
        'bell_id',
        'period_type_id',
        'organization_id',
        'year_id'
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
    
    public function periodType()
    {
        return $this->belongsTo(PeriodType::class, 'period_type_id');
    }

    public function bell()
    {
        return $this->belongsTo(Bell::class, 'bell_id');
    }
    
}

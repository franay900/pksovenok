<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodType extends Model
{
    use HasFactory;
    public $timestamps = false;


    protected $fillable = [
        'name',
        'name_many',
        'quantity'
    ];
}
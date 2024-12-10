<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = false;
    protected $with = ['user', 'group'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

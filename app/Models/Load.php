<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    use HasFactory;
    
    protected $fillable = ['group_id', 'subgroup_id', 'subject_id', 'teacher_id'];


    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
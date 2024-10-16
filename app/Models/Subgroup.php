<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subgroup extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'subject_id', 'group_id'];

    public function subject()
    {
      return $this->belongsTo(Subject::class); 
    }
    
}

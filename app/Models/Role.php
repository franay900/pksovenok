<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'key'];



    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions'); // Убедитесь в названии промежуточной таблицы!
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'roles_user');
    }
}

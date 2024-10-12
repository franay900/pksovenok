<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'patronymic',
        'email',
        'username',
        'organization_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }

    // Метод для проверки наличия определенной роли
    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }

    public static function getTeachersByOrganization($organizationId)
    {
        return self::where('organization_id', $organizationId)
            ->whereHas('roles', function ($query) {
                $query->where('key', 'teacher'); // Фильтр по роли
            })
            ->orderBy('surname', 'asc')
            ->get();
    }

    public function hasPermission($permissionKey)
    {
        if (is_null($this->roles)) {
            return false; // Пользователь не имеет ни одной роли
        }
    
        foreach ($this->roles as $role) {

            if (!is_null($role->permissions) && $role->permissions->contains('key', $permissionKey)) {
                return true;
            }
        }
    
        return false;
    }
}

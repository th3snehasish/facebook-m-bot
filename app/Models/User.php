<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get user projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    /**
     * Get user permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions', 'user_id', 'permission_id');
    }

    /**
     * @return mixed
     */
    public function getDisplayNameAttribute()
    {
        if (Str::length($this->name) > 0) {
            return $this->name;
        }

        return $this->email;
    }
}

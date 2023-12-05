<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "password",
        "role",
    ];

    protected $hidden = [
        "password",
        "updated_at"
    ];

    protected $casts = [
        "password" => "hashed"
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function projects()
    {
        return $this->hasMany(Project::class, "user_id", "id");
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, "user_id", "id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, "user_id", "id");
    }
}

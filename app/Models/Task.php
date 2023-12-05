<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        "project_id",
        "title",
        "description",
        "user_id",
        "status",
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, "project_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, "task_id", "id");
    }

    public function files()
    {
        return $this->hasManyThrough(File::class, TaskFile::class, "task_id", "id", "id", "file_id");
    }
}

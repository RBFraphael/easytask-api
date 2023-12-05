<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        "task_id",
        "user_id",
        "comment",
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, "task_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function files()
    {
        return $this->hasManyThrough(File::class, CommentFile::class, "comment_id", "id", "id", "file_id");
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        "path",
        "name"
    ];

    protected $appends = [
        "url"
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "path"
    ];

    protected static function booted()
    {
        static::deleted(function(File $file){
            if(Storage::disk("public")->exists($file->path)){
                Storage::disk("public")->delete($file->path);
            }
        });
    }

    public function getUrlAttribute()
    {
        return url(Storage::url($this->path));
    }
}

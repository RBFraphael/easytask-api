<?php

namespace App\Repositories;

use App\Models\File;

class FileRepository {

    public function createFile(array $fileData)
    {
        $file = File::create($fileData);
        return $file;
    }
    
    public function getFileById(int $fileId)
    {
        $file = File::findOrFail($fileId);
        
        return $file;
    }
    
    public function deleteFile(int $fileId)
    {
        $file = File::findOrFail($fileId);
        $file->delete();
    }

}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\StoreFileRequest;
use App\Models\File;
use App\Repositories\FileRepository;
use Illuminate\Http\Response;

class FileController extends Controller
{
    public function __construct(
        private FileRepository $repository
    ) { }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request)
    {
        $inputFile = $request->file("file");
        $fileName = $inputFile->getClientOriginalName();
        $directory = "uploads/".date("Y/m");
        $path = $inputFile->store($directory, "public");

        $file = $this->repository->createFile([
            'name' => $fileName,
            'path' => $path
        ]);

        return response()->json($file, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        $file = $this->repository->getFileById($file->id);

        return response()->json($file);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        $this->repository->deleteFile($file->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

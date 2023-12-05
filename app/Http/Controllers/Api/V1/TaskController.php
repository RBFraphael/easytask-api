<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Models\Task;
use App\Repositories\TaskRepository;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(
        private TaskRepository $repository
    ) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = $this->repository->getAllTasks(
            request("with", ""),
            request("filters", ""),
            request("page", 1),
            request("per_page", 10),
            request("order", "ASC"),
            request("order_by", "id")
        );

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        return response()->json(
            $this->repository->createTask($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task = $this->repository->getTaskById(
            $task->id,
            request("with", "")
        );
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        return response()->json(
            $this->repository->updateTask($task->id, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->repository->deleteTask($task->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

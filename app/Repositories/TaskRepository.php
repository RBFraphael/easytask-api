<?php

namespace App\Repositories;

use App\Enums\UserRole;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;

class TaskRepository {

    public function createTask(array $taskData)
    {
        $task = Task::create($taskData);
        return $task;
    }
    
    public function getAllTasks(string $load = "", string $filters = "", int $page = 1, int $per_page = 10, string $order = "ASC", string $orderBy = "id")
    {
        $tasks = Task::query();

        $loggedUser = auth()->user();
        if($loggedUser->role == UserRole::MANAGER){
            $tasks = $tasks->whereHas("project", function(Builder $query) use($loggedUser){
                $query->where("user_id", $loggedUser->id);
            });
        } else if($loggedUser->role == UserRole::OPERATIONAL){
            $tasks = $tasks->where("user_id", $loggedUser->id);
        }

        if(strlen($filters) > 0){
            $filters = explode(",", $filters);
            foreach($filters as $filter){
                [$cond, $value] = explode(":", $filter);
                $tasks = $tasks->where($cond, $value);
            }
        }
        
        if(strlen($load) > 0){
            $tasks = $tasks->with(
                explode(",", $load)
            );
        }

        $tasks = $tasks->orderBy($orderBy, $order);
        $tasks = $tasks->paginate($per_page, ["*"], "page", $page);

        $data = [
            'current_page' => $tasks->currentPage(),
            'data' => $tasks->items(),
            'from' => $tasks->firstItem(),
            'last_page' => $tasks->lastPage(),
            'order' => $order,
            'order_by' => $orderBy,
            'per_page' => $tasks->perPage(),
            'to' => $tasks->lastItem(),
            'total' => $tasks->total(),
        ];
        
        return $data;
    }
    
    public function getTaskById(int $taskId, string $load = "")
    {
        $task = Task::findOrFail($taskId);
        
        if(strlen($load) > 0){
            $task->load(
                explode(",", $load)
            );
        }
        
        return $task;
    }
    
    public function updateTask(int $taskId, array $taskData)
    {
        $task = Task::findOrFail($taskId);
        $task->update($taskData);
        return $task;
    }
    
    public function deleteTask(int $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->delete();
    }

}

<?php

namespace App\Repositories;

use App\Enums\UserRole;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;

class ProjectRepository {

    public function createProject(array $projectData)
    {
        $project = Project::create($projectData);
        return $project;
    }
    
    public function getAllProjects(string $load = "", string $filters = "", int $page = 1, int $per_page = 10, string $order = "ASC", string $orderBy = "id")
    {
        $projects = Project::query();

        $loggedUser = auth()->user();
        if($loggedUser->role == UserRole::MANAGER){
            $projects = $projects->where("user_id", $loggedUser->id);
        } else if($loggedUser->role == UserRole::OPERATIONAL){
            $projects = $projects->whereHas("tasks", function(Builder $query) use($loggedUser){
                $query->where("user_id", $loggedUser->id);
            });
        }

        if(strlen($filters) > 0){
            $filters = explode(",", $filters);
            foreach($filters as $filter){
                [$cond, $value] = explode(":", $filter);
                $projects->where($cond, $value);
            }
        }

        if(strlen($load) > 0){
            $projects->with(
                explode(",", $load)
            );
        }

        $projects = $projects->orderBy($orderBy, $order);
        $projects = $projects->paginate($per_page, ["*"], "page", $page);

        $data = [
            'current_page' => $projects->currentPage(),
            'data' => $projects->items(),
            'from' => $projects->firstItem(),
            'last_page' => $projects->lastPage(),
            'order' => $order,
            'order_by' => $orderBy,
            'per_page' => $projects->perPage(),
            'to' => $projects->lastItem(),
            'total' => $projects->total(),
        ];
        
        return $data;
    }
    
    public function getProjectById(int $projectId, string $load = "")
    {
        $project = Project::findOrFail($projectId);
        
        if(strlen($load) > 0){
            $project->load(
                explode(",", $load)
            );
        }
        
        return $project;
    }
    
    public function updateProject(int $projectId, array $projectData)
    {
        $project = Project::findOrFail($projectId);
        $project->update($projectData);
        return $project;
    }
    
    public function deleteProject(int $projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->delete();
    }

}

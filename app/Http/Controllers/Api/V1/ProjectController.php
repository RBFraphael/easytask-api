<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectRepository $repository
    ) { }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = $this->repository->getAllProjects(
            request("with", ""),
            request("filters", ""),
            request("page", 1),
            request("per_page", 10),
            request("order", "ASC"),
            request("order_by", "id")
        );

        return response()->json($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        return response()->json(
            $this->repository->createProject($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project = $this->repository->getProjectById(
            $project->id,
            request("with", "")
        );
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        return response()->json(
            $this->repository->updateProject($project->id, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->repository->deleteProject($project->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

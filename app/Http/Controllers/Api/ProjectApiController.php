<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ProjectApiController extends Controller
{
    public function index()
    {
        $projects = Project::with('users')->get();
        return ProjectResource::collection($projects);
    }

    public function store(Request $request)
    {
        $project = Project::create($request->all());
        return new ProjectResource($project);
    }

    public function show($id)
    {
        $project = Project::with('users')->findOrFail($id);
        return new ProjectResource($project);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return new ProjectResource($project);
    }

    public function destroy($id)
    {
        Project::findOrFail($id)->delete();
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }

    public function attachUser(Request $request, $projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->users()->attach($request->user_id);
        return response()->json($project->users, 200);
    }

    public function detachUser(Request $request, $projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->users()->detach($request->user_id);
        return response()->json($project->users, 200);
    }
}
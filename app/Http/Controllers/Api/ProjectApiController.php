<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectApiController extends Controller
{
    public function index()
    {
        $projects = Project::with('users')->get();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $project = Project::create($request->all());
        return response()->json($project, 201);
    }

    public function show($id)
    {
        $project = Project::with('users')->findOrFail($id);
        return response()->json($project);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return response()->json($project, 200);
    }

    public function destroy($id)
    {
        Project::findOrFail($id)->delete();
        return response()->json(null, 204);
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

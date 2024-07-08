<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Inertia\Inertia;

class ReportWebController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return Inertia::render('Projects/Index', [
            'projects' => $projects
        ]);
    }

    public function show($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Project not found');
        }
        return Inertia::render('Projects/Show', [
            'project' => $project
        ]);
    }

    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    public function store(Request $request)
    {
        $project = Project::create($request->all());
        return redirect()->route('projects.index')->with('success', 'Project created successfully');
    }

    public function edit($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Project not found');
        }
        return Inertia::render('Projects/Edit', [
            'project' => $project
        ]);
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Project not found');
        }
        $project->update($request->all());
        return redirect()->route('projects.index')->with('success', 'Project updated successfully');
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Project not found');
        }
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
    }
}

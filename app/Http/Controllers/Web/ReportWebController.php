<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use Inertia\Inertia;

class ReportWebController extends Controller
{
public function index()
    {
        $reports = Report::all();
        return Inertia::render('Reports/Index', [
            'reports' => $reports
        ]);
    }

    public function show($id)
    {
        $report = Report::find($id);
        if (!$report) {
            return redirect()->route('reports.index')->with('error', 'Report not found');
        }
        return Inertia::render('Reports/Show', [
            'report' => $report
        ]);
    }

    public function create()
    {
        return Inertia::render('Reports/Create');
    }

    public function store(Request $request)
    {
        $report = Report::create($request->all());
        return redirect()->route('reports.index')->with('success', 'Report created successfully');
    }

    public function edit($id)
    {
        $report = Report::find($id);
        if (!$report) {
            return redirect()->route('reports.index')->with('error', 'Report not found');
        }
        return Inertia::render('Reports/Edit', [
            'report' => $report
        ]);
    }

    public function update(Request $request, $id)
    {
        $report = Report::find($id);
        if (!$report) {
            return redirect()->route('reports.index')->with('error', 'Report not found');
        }
        $report->update($request->all());
        return redirect()->route('reports.index')->with('success', 'Report updated successfully');
    }

    public function destroy($id)
    {
        $report = Report::find($id);
        if (!$report) {
            return redirect()->route('reports.index')->with('error', 'Report not found');
        }
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully');
    }
}


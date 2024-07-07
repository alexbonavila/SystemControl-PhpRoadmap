<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ReportApiController extends Controller
{
    public function index()
    {
        $reports = Report::all();
        return ReportResource::collection($reports);
    }

    public function store(ReportRequest $request)
    {
        $report = Report::create($request->validated());
        return new ReportResource($report);
    }

    public function show($id)
    {
        $report = Report::findOrFail($id);
        return new ReportResource($report);
    }

    public function update(ReportRequest $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->update($request->validated());
        return new ReportResource($report);
    }

    public function destroy($id)
    {
        Report::findOrFail($id)->delete();
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}

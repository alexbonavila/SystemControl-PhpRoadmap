<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ReportApiController extends Controller
{
    public function index()
    {
        $reports = Report::all();
        return ReportResource::collection($reports);
    }

    public function store(Request $request)
    {
        $report = Report::create($request->all());
        return new ReportResource($report);
    }

    public function show($id)
    {
        $report = Report::findOrFail($id);
        return new ReportResource($report);
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->update($request->all());
        return new ReportResource($report);
    }

    public function destroy($id)
    {
        Report::findOrFail($id)->delete();
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}

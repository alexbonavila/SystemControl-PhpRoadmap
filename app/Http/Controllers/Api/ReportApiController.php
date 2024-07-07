<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;



class ReportApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/reports",
     *     summary="Get all reports",
     *     tags={"Report"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        $reports = Report::all();
        return ReportResource::collection($reports);
    }

    /**
     * @OA\Post(
     *     path="/api/reports",
     *     summary="Create a new report",
     *     tags={"Report"},
     *     @OA\Response(
     *         response=201,
     *         description="Report created"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(ReportRequest $request): ReportResource
    {
        $report = Report::create($request->validated());
        return new ReportResource($report);
    }

    /**
     * @OA\Get(
     *     path="/api/reports/{id}",
     *     summary="Get a report by ID",
     *     tags={"Report"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the report",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */
    public function show($id): ReportResource
    {
        $report = Report::findOrFail($id);
        return new ReportResource($report);
    }

    /**
     * @OA\Put(
     *     path="/api/reports/{id}",
     *     summary="Update a report by ID",
     *     tags={"Report"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the report",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="content",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Report updated"
     *     )
     * )
     */
    public function update(ReportRequest $request, $id): ReportResource
    {
        $report = Report::findOrFail($id);
        $report->update($request->validated());
        return new ReportResource($report);
    }

    /**
     * @OA\Delete(
     *     path="/api/reports/{id}",
     *     summary="Delete a report by ID",
     *     tags={"Report"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the report",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Report deleted"
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        Report::findOrFail($id)->delete();
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}

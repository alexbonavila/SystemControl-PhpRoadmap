<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class ProjectApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/projects",
     *     summary="Get all projects",
     *     tags={"Project"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        $projects = Project::with('users')->get();
        return ProjectResource::collection($projects);
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     summary="Create a new project",
     *     tags={"Project"},
     *     @OA\Response(
     *         response=201,
     *         description="Project created"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(ProjectRequest $request): ProjectResource
    {
        $project = Project::create($request->validated());
        return new ProjectResource($project);
    }

    /**
     * @OA\Get(
     *     path="/api/projects/{id}",
     *     summary="Get a project by ID",
     *     tags={"Project"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the project",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */
    public function show($id): ProjectResource
    {
        $project = Project::with('users')->findOrFail($id);
        return new ProjectResource($project);
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     summary="Update a project by ID",
     *     tags={"Project"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the project",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Project updated"
     *     )
     * )
     */
    public function update(ProjectRequest $request, $id): ProjectResource
    {
        $project = Project::findOrFail($id);
        $project->update($request->validated());
        return new ProjectResource($project);
    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     summary="Delete a project by ID",
     *     tags={"Project"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the project",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Project deleted"
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        Project::findOrFail($id)->delete();
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Post(
     *     path="/api/projects/{id}/attach-user",
     *     summary="Attach a user to a project",
     *     tags={"Project"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the project",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User attached successfully"
     *     )
     * )
     */
    public function attachUser(Request $request, $projectId): JsonResponse
    {
        $project = Project::findOrFail($projectId);
        $project->users()->attach($request->user_id);
        return response()->json($project->users, ResponseAlias::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/projects/{id}/detach-user",
     *     summary="Detach a user from a project",
     *     tags={"Project"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the project",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User detached successfully"
     *     )
     * )
     */
    public function detachUser(Request $request, $projectId): JsonResponse
    {
        $project = Project::findOrFail($projectId);
        $project->users()->detach($request->user_id);
        return response()->json($project->users, ResponseAlias::HTTP_OK);
    }
}


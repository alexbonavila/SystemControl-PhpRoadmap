<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Http\Requests\ConfigurationRequest;
use App\Http\Resources\ConfigurationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class ConfigurationApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/configurations",
     *     summary="Get all configurations",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        $configurations = Configuration::with('device')->get();
        return ConfigurationResource::collection($configurations);
    }

    /**
     * @OA\Post(
     *     path="/api/configurations",
     *     summary="Create a new configuration",
     *     @OA\Response(
     *         response=201,
     *         description="Configuration created"
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
     *                     property="value",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(ConfigurationRequest $request): ConfigurationResource
    {
        $configuration = Configuration::create($request->validated());
        return new ConfigurationResource($configuration);
    }

    /**
     * @OA\Get(
     *     path="/api/configurations/{id}",
     *     summary="Get a configuration by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the configuration",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */
    public function show($id): ConfigurationResource
    {
        $configuration = Configuration::with('device')->findOrFail($id);
        return new ConfigurationResource($configuration);
    }

    /**
     * @OA\Put(
     *     path="/api/configurations/{id}",
     *     summary="Update a configuration by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the configuration",
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
     *                     property="value",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Configuration updated"
     *     )
     * )
     */
    public function update(ConfigurationRequest $request, $id): ConfigurationResource
    {
        $configuration = Configuration::findOrFail($id);
        $configuration->update($request->validated());
        return new ConfigurationResource($configuration);
    }

    /**
     * @OA\Delete(
     *     path="/api/configurations/{id}",
     *     summary="Delete a configuration by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the configuration",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Configuration deleted"
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        Configuration::findOrFail($id)->delete();
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}


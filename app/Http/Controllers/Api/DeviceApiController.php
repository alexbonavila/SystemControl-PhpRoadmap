<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\DeviceRequest;
use App\Http\Resources\DeviceResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class DeviceApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/devices",
     *     summary="Get all devices",
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */
    public function index(): AnonymousResourceCollection
    {
        $devices = Device::with('configuration')->get();
        return DeviceResource::collection($devices);
    }

    /**
     * @OA\Post(
     *     path="/api/devices",
     *     summary="Create a new device",
     *     @OA\Response(
     *         response=201,
     *         description="Device created"
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
     *                     property="type",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(DeviceRequest $request): DeviceResource
    {
        $device = Device::create($request->validated());
        return new DeviceResource($device);
    }

    /**
     * @OA\Get(
     *     path="/api/devices/{id}",
     *     summary="Get a device by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the device",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     )
     * )
     */
    public function show($id): DeviceResource
    {
        $device = Device::with('configuration')->findOrFail($id);
        return new DeviceResource($device);
    }

    /**
     * @OA\Put(
     *     path="/api/devices/{id}",
     *     summary="Update a device by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the device",
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
     *                     property="type",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device updated"
     *     )
     * )
     */
    public function update(DeviceRequest $request, $id): DeviceResource
    {
        $device = Device::findOrFail($id);
        $device->update($request->validated());
        return new DeviceResource($device);
    }

    /**
     * @OA\Delete(
     *     path="/api/devices/{id}",
     *     summary="Delete a device by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the device",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Device deleted"
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        Device::findOrFail($id)->delete();
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}

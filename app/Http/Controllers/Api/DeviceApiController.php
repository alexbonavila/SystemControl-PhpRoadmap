<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Http\Requests\DeviceRequest;
use App\Http\Resources\DeviceResource;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class DeviceApiController extends Controller
{
    public function index()
    {
        $devices = Device::with('configuration')->get();
        return DeviceResource::collection($devices);
    }

    public function store(DeviceRequest $request)
    {
        $device = Device::create($request->validated());
        return new DeviceResource($device);
    }

    public function show($id)
    {
        $device = Device::with('configuration')->findOrFail($id);
        return new DeviceResource($device);
    }

    public function update(DeviceRequest $request, $id)
    {
        $device = Device::findOrFail($id);
        $device->update($request->validated());
        return new DeviceResource($device);
    }

    public function destroy($id)
    {
        Device::findOrFail($id)->delete();
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class DeviceApiController extends Controller
{
    public function index()
    {
        $devices = Device::with('configuration')->get();
        return DeviceResource::collection($devices);
    }

    public function store(Request $request)
    {
        $device = Device::create($request->all());
        return new DeviceResource($device);
    }

    public function show($id)
    {
        $device = Device::with('configuration')->findOrFail($id);
        return new DeviceResource($device);
    }

    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);
        $device->update($request->all());
        return new DeviceResource($device);
    }

    public function destroy($id)
    {
        Device::findOrFail($id)->delete();
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}

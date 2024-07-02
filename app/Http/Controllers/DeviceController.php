<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::with('configuration')->get();
        return response()->json($devices);
    }

    public function store(Request $request)
    {
        $device = Device::create($request->all());
        return response()->json($device, 201);
    }

    public function show($id)
    {
        $device = Device::with('configuration')->findOrFail($id);
        return response()->json($device);
    }

    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);
        $device->update($request->all());
        return response()->json($device, 200);
    }

    public function destroy($id)
    {
        Device::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}

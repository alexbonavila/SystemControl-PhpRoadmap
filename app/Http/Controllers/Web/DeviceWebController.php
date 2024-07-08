<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use Inertia\Inertia;

class DeviceWebController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return Inertia::render('Devices/Index', [
            'devices' => $devices
        ]);
    }

    public function show($id)
    {
        $device = Device::find($id);
        if (!$device) {
            return redirect()->route('devices.index')->with('error', 'Device not found');
        }
        return Inertia::render('Devices/Show', [
            'device' => $device
        ]);
    }

    public function create()
    {
        return Inertia::render('Devices/Create');
    }

    public function store(Request $request)
    {
        $device = Device::create($request->all());
        return redirect()->route('devices.index')->with('success', 'Device created successfully');
    }

    public function edit($id)
    {
        $device = Device::find($id);
        if (!$device) {
            return redirect()->route('devices.index')->with('error', 'Device not found');
        }
        return Inertia::render('Devices/Edit', [
            'device' => $device
        ]);
    }

    public function update(Request $request, $id)
    {
        $device = Device::find($id);
        if (!$device) {
            return redirect()->route('devices.index')->with('error', 'Device not found');
        }
        $device->update($request->all());
        return redirect()->route('devices.index')->with('success', 'Device updated successfully');
    }

    public function destroy($id)
    {
        $device = Device::find($id);
        if (!$device) {
            return redirect()->route('devices.index')->with('error', 'Device not found');
        }
        $device->delete();
        return redirect()->route('devices.index')->with('success', 'Device deleted successfully');
    }
}

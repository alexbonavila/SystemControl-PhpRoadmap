<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    public function index()
    {
        $configurations = Configuration::with('device')->get();
        return response()->json($configurations);
    }

    public function store(Request $request)
    {
        $configuration = Configuration::create($request->all());
        return response()->json($configuration, 201);
    }

    public function show($id)
    {
        $configuration = Configuration::with('device')->findOrFail($id);
        return response()->json($configuration);
    }

    public function update(Request $request, $id)
    {
        $configuration = Configuration::findOrFail($id);
        $configuration->update($request->all());
        return response()->json($configuration, 200);
    }

    public function destroy($id)
    {
        Configuration::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}

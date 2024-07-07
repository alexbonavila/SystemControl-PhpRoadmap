<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConfigurationResource;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ConfigurationApiController extends Controller
{
    public function index()
    {
        $configurations = Configuration::with('device')->get();
        return ConfigurationResource::collection($configurations);
    }

    public function store(Request $request)
    {
        $configuration = Configuration::create($request->all());
        return new ConfigurationResource($configuration);
    }

    public function show($id)
    {
        $configuration = Configuration::with('device')->findOrFail($id);
        return new ConfigurationResource($configuration);
    }

    public function update(Request $request, $id)
    {
        $configuration = Configuration::findOrFail($id);
        $configuration->update($request->all());
        return new ConfigurationResource($configuration);
    }

    public function destroy($id)
    {
        Configuration::findOrFail($id)->delete();
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}

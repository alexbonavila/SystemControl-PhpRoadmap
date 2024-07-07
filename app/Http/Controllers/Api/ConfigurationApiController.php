<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use App\Http\Requests\ConfigurationRequest;
use App\Http\Resources\ConfigurationResource;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ConfigurationApiController extends Controller
{
    public function index()
    {
        $configurations = Configuration::with('device')->get();
        return ConfigurationResource::collection($configurations);
    }

    public function store(ConfigurationRequest $request)
    {
        $configuration = Configuration::create($request->validated());
        return new ConfigurationResource($configuration);
    }

    public function show($id)
    {
        $configuration = Configuration::with('device')->findOrFail($id);
        return new ConfigurationResource($configuration);
    }

    public function update(ConfigurationRequest $request, $id)
    {
        $configuration = Configuration::findOrFail($id);
        $configuration->update($request->validated());
        return new ConfigurationResource($configuration);
    }

    public function destroy($id)
    {
        Configuration::findOrFail($id)->delete();
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}


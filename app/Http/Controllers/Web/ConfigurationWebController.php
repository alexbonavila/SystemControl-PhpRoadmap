<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuration;
use Inertia\Inertia;

class ConfigurationWebController extends Controller
{
    public function index()
    {
        $configurations = Configuration::all();
        return Inertia::render('Configurations/Index', [
            'configurations' => $configurations
        ]);
    }

    public function show($id)
    {
        $configuration = Configuration::find($id);
        if (!$configuration) {
            return redirect()->route('configurations.index')->with('error', 'Configuration.vue not found');
        }
        return Inertia::render('Configurations/Show', [
            'configuration' => $configuration
        ]);
    }

    public function create()
    {
        return Inertia::render('Configurations/Create');
    }

    public function store(Request $request)
    {
        $configuration = Configuration::create($request->all());
        return redirect()->route('configurations.index')->with('success', 'Configuration.vue created successfully');
    }

    public function edit($id)
    {
        $configuration = Configuration::find($id);
        if (!$configuration) {
            return redirect()->route('configurations.index')->with('error', 'Configuration.vue not found');
        }
        return Inertia::render('Configurations/Edit', [
            'configuration' => $configuration
        ]);
    }

    public function update(Request $request, $id)
    {
        $configuration = Configuration::find($id);
        if (!$configuration) {
            return redirect()->route('configurations.index')->with('error', 'Configuration.vue not found');
        }
        $configuration->update($request->all());
        return redirect()->route('configurations.index')->with('success', 'Configuration.vue updated successfully');
    }

    public function destroy($id)
    {
        $configuration = Configuration::find($id);
        if (!$configuration) {
            return redirect()->route('configurations.index')->with('error', 'Configuration.vue not found');
        }
        $configuration->delete();
        return redirect()->route('configurations.index')->with('success', 'Configuration.vue deleted successfully');
    }
}

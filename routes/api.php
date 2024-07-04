<?php

use App\Http\Controllers\Api\ConfigurationController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Default route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Application Routes
Route::middleware('auth:api')->group(function () {
    Route::apiResource('devices', DeviceController::class);
    Route::apiResource('configurations', ConfigurationController::class);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('reports', ReportController::class);

    Route::post('projects/{project}/attach-user', [ProjectController::class, 'attachUser']);
    Route::post('projects/{project}/detach-user', [ProjectController::class, 'detachUser']);
});

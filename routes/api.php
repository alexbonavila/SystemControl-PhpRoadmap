<?php

use App\Http\Controllers\Api\ConfigurationApiController;
use App\Http\Controllers\Api\DeviceApiController;
use App\Http\Controllers\Api\ProjectApiController;
use App\Http\Controllers\Api\ReportApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Default route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Application Routes
Route::middleware('auth:api')->group(function () {
    Route::apiResource('devices', DeviceApiController::class);
    Route::apiResource('configurations', ConfigurationApiController::class);
    Route::apiResource('projects', ProjectApiController::class);
    Route::apiResource('reports', ReportApiController::class);

    Route::post('projects/{project}/attach-user', [ProjectApiController::class, 'attachUser']);
    Route::post('projects/{project}/detach-user', [ProjectApiController::class, 'detachUser']);
});

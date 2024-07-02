<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;

// Default route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



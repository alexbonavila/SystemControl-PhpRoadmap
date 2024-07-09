<?php

use App\Http\Controllers\Web\ConfigurationWebController;
use App\Http\Controllers\Web\DashboardWebController;
use App\Http\Controllers\Web\DeviceWebController;
use App\Http\Controllers\Web\ProjectWebController;
use App\Http\Controllers\Web\ReportWebController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified',
//])->group(function () {
//    Route::get('/dashboard', function () {
//        return Inertia::render('Dashboard');
//    })->name('dashboard');
//});

// Web authenticated routes
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardWebController::class, 'index'])->name('dashboard');

    Route::resource('configurations', ConfigurationWebController::class);
    Route::resource('devices', DeviceWebController::class);
    Route::resource('projects', ProjectWebController::class);
    Route::resource('reports', ReportWebController::class);
});

<?php

use App\Helpers\KNN;
use App\Http\Controllers\APIController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PolutionController;
use App\Http\Controllers\DetectionController;
use App\Models\WaterQuality;

// Default route
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    // Profiles
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Sensor measurement
    Route::prefix('/sensor')->name('sensor.')->group(function(){
        Route::get('/', [SensorController::class, 'index'])->name('index');
        Route::delete('/{water_quality}', [SensorController::class, 'destroy'])->name('destroy');
    });

    // Garbage detection
    Route::prefix('/detection')->name('detection.')->group(function(){
        Route::get('/', [DetectionController::class, 'index'])->name('index');
        Route::delete('/{garbage_detection}', [DetectionController::class, 'destroy'])->name('destroy');
    });

    // Polution level
    Route::prefix('/polution')->name('polution.')->group(function(){
        Route::get('/', [PolutionController::class, 'index'])->name('index');
    });
});

// APIs
Route::post('/api/send-sensor-data', [APIController::class, 'store_sensor_data']);
Route::post('/api/send-detection-data', [APIController::class, 'store_detection_data']);

require __DIR__.'/auth.php';

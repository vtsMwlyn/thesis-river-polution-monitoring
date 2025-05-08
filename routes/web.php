<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PolutionController;
use App\Http\Controllers\DetectionController;

// Default route
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profiles
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Sensor measurement
    Route::prefix('/sensor')->name('sensor.')->group(function(){
        Route::get('/', [SensorController::class, 'index'])->name('index');
    });

    // Garbage detection
    Route::prefix('/detection')->name('detection.')->group(function(){
        Route::get('/', [DetectionController::class, 'index'])->name('index');
    });

    // Polution level
    Route::prefix('/polution')->name('polution.')->group(function(){
        Route::get('/', [PolutionController::class, 'index'])->name('index');
    });
});

require __DIR__.'/auth.php';

<?php

use App\Helpers\KNN;
use App\Http\Controllers\APIController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PolutionController;
use App\Http\Controllers\DetectionController;
use App\Models\Warning;
use App\Models\WaterQuality;

// Default route
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/confusionmatrix', function(){
    return view('confusionmatrix', [
        'labels' => KNN::confusion_matrix()
    ]);
})->name('confusion-matrix');

Route::get('/regenerate-warning', function(){
    foreach(Warning::all() as $w){
        $w->delete();
    }

    $prev_wq = null;

    foreach(WaterQuality::all() as $wq){
        // Retrieve data
        $temp = $wq->temp;
        $ph = $wq->ph;
        $turbidity = $wq->turbidity;
        $tds = $wq->tds;

        // Find parameters that may cause the decreasing of the quality
        $out_of_standards = [];

        if($temp < 12 || $temp > 25){
            $out_of_standards[] = 'suhu';
        }

        if($ph < 6.5 || $ph > 8.5){
            $out_of_standards[] = 'pH';
        }

        if($turbidity < 1 || $turbidity > 5){
            $out_of_standards[] = 'tingkat kekeruhan';
        }

        if($tds > 600){
            $out_of_standards[] = 'jumlah padatan terlarut';
        }

        // Text formatting
        $sus_parameters = '';

        if (count($out_of_standards) > 1) {
            $lastItem = array_pop($out_of_standards);
            $sus_parameters = implode(', ', $out_of_standards) . ', dan ' . $lastItem;
        } else {
            $sus_parameters = implode('', $out_of_standards);
        }

        // Predict the water quality
        $quality = $wq->quality;

        // Retrieve last data
        if($prev_wq !== null){
            $latest_sensor_data = $prev_wq;

            // Compare: If the quality turned to bad or very bad, then generate warning
            if($latest_sensor_data && !in_array($latest_sensor_data?->quality, ['Bad', 'Very Bad']) && in_array($quality, ['Bad', 'Very Bad'])){
                $translated = '';

                if($quality == 'Bad'){
                    $translated = 'Buruk';
                } else if($quality == 'Very Bad'){
                    $translated = 'Sangat Buruk';
                }

                Warning::create([
                    'date_and_time' => $wq->date_and_time,
                    'message' => 'Terjadi penurunan kualitas air sungai di lokasi ' . $wq->location . ' ke tingkat <strong>"' . $translated .'"</strong>. Beberapa parameter seperti <strong>' . $sus_parameters . '</strong> diduga menyebabkan penurunan.',
                    'category' => $quality,
                ]);
            }
        }

        $prev_wq = $wq;
    }

    return "Done";
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

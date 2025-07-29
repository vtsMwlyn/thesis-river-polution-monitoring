<?php

namespace App\Http\Controllers;

use App\Helpers\KNN;
use App\Models\GarbageDetection;
use App\Models\Warning;
use App\Models\WaterQuality;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function store_sensor_data(Request $request){
        try {
            if($request->secret == 'VTS_Meowlynna-2312'){
                DB::beginTransaction();

                // Data validation
                $validSensorData = $request->validate([
                    'temp' => 'required|numeric|min:0',
                    'ph' => 'required|numeric|min:0',
                    'turbidity' => 'required|numeric|min:0',
                    'tds' => 'required|numeric|min:0',
                    'location' => 'nullable|string'
                ]);

                // Retrieve data
                $temp = $validSensorData['temp'];
                $ph = $validSensorData['ph'];
                $turbidity = $validSensorData['turbidity'];
                $tds = $validSensorData['tds'];
                $location = $validSensorData['location'];

                // Predict the water quality
                $quality = KNN::predict($temp, $ph, $turbidity, $tds);

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

                $sus_parameters = '';

                if (count($out_of_standards) > 1) {
                    $lastItem = array_pop($out_of_standards);
                    $sus_parameters = implode(', ', $out_of_standards) . ', dan ' . $lastItem;
                } else {
                    $sus_parameters = implode('', $out_of_standards);
                }

                //===== WARNING GENERATION MECHANISM ===== //
                // Retrieve last data
                $latest_sensor_data = WaterQuality::latest()->first();

                // Compare: If the quality turned to bad or very bad, then generate warning
                if($latest_sensor_data && !in_array($latest_sensor_data?->quality, ['Bad', 'Very Bad']) && in_array($quality, ['Bad', 'Very Bad'])){
                    $translated = '';

                    if($quality == 'Bad'){
                        $translated = 'Buruk';
                    } else if($quality == 'Very Bad'){
                        $translated = 'Sangat Buruk';
                    }

                    Warning::create([
                        'date_and_time' => Carbon::now()->format('Y-m-d H:i:s'),
                        'message' => 'Terjadi penurunan kualitas air sungai di lokasi ' . $location . ' ke tingkat <strong>"' . $translated .'"</strong>. Beberapa parameter seperti <strong>' . $sus_parameters . '</strong> diduga menyebabkan penurunan.',
                        'category' => $quality,
                    ]);
                }

                // Finally, store the sensor and quality data
                $validSensorData['date_and_time'] = Carbon::now()->format('Y-m-d H:i:s');
                $validSensorData['quality'] = $quality;

                WaterQuality::create($validSensorData);

                DB::commit();

                // Give success response back to the data sender
                return response()->json(['success' => true, 'message' => 'Successfully stored the sensor data!'], 200);
            }
            else {
                abort(401);
            }
        }
        catch(Exception $e){
            DB::rollback();

            return response()->json(['success' => false, 'message' => 'Error occured: ' . $e->getMessage()], 500);
        }
    }

    public function store_detection_data(Request $request){
        if($request->secret == 'VTS_Meowlynna-2312'){
            // Data validation
            $validDetectionData = $request->validate([
                'date_and_time' => 'required|string',
                'location' => 'nullable|string',
                'number' => 'required|numeric|min:0',
                'image' => 'file|image',
            ]);

            // Store detection photo
            $path = $request->file('image')->store('detections');
            $validDetectionData['image_path'] = $path;

            // Store detection data to database
            GarbageDetection::create($validDetectionData);

            // Give success response back to the data sender
            return response()->json(['success' => true, 'message' => 'Successfully stored the detection data!'], 200);
        }
        else {
            abort(401);
        }
    }
}

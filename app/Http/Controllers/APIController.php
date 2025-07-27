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

                // Retrieve data
                $temp = $request->temp;
                $ph = $request->ph;
                $turbidity = $request->turbidity;
                $tds = $request->tds;
                $location = $request->location ?? null;

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
                $quality = KNN::predict($temp, $ph, $turbidity, $tds);

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
                WaterQuality::create([
                    'date_and_time' => Carbon::now()->format('Y-m-d H:i:s'),
                    'location' => $location,

                    'temp' => $temp,
                    'ph' => $ph,
                    'turbidity' => $turbidity,
                    'tds' => $tds,

                    'quality' => $quality,
                ]);

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
            // Store detection photo
            $path = $request->file('image')->store('detections');

            // Store detection data to database
            GarbageDetection::create([
                'date_and_time' => $request->date_and_time,
                'location' => $request->location ?? null,
                'number' => $request->number,
                'image_path' => $path,
            ]);

            // Give success response back to the data sender
            return response()->json(['success' => true, 'message' => 'Successfully stored the detection data!'], 200);
        }
        else {
            abort(401);
        }
    }
}

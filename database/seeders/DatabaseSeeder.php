<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Helpers\KNN;
use App\Models\GarbageDetection;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Warning;
use App\Models\WaterQuality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('password')
        ]);

        // Generate fake sensors data
        $temp = mt_rand(5, 30);
        $ph = mt_rand(50, 90) / 10; // Force to be float (5.0 to 9.0)
        $turbidity = mt_rand(5, 100) / 10; // Force to be float (0.5 to 10)
        $tds = mt_rand(50, 600);

        $number_detected = mt_rand(0, 10);

        $baseTimestamp = Carbon::now();
        $sensorData = [];

        $prev_quality = '';

        for ($i = 0; $i < 1000; $i++) {
            // Subtract 5 minutes (300 seconds) for each iteration
            $timestamp = (clone $baseTimestamp)->subSeconds($i * 300);

            $temp += mt_rand(-5, 5);
            $ph += mt_rand(-20, 20) / 10; // Small float adjustment
            $turbidity += mt_rand(-30, 30) / 10; // Small float adjustment
            $tds += mt_rand(-50, 50);

            if(mt_rand(0, 3) == 0){
                $number_detected += mt_rand(-2, 2);
            }

            // Prevent negative values
            $temp = ($temp < 0) ? 0 : $temp;
            $ph = ($ph < 0) ? 0 : round($ph, 2);
            $turbidity = ($turbidity < 0) ? 0 : round($turbidity, 2);
            $tds = ($tds < 0) ? 0 : $tds;

            // Prevent exessive values
            $temp = ($temp > 50) ? 50 : $temp;
            $ph = ($ph > 14) ? 14 : round($ph, 2);

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
                $lastItem = array_pop($out_of_standards); // Remove the last item
                $sus_parameters = implode(', ', $out_of_standards) . ', dan ' . $lastItem;
            } else {
                $sus_parameters = implode('', $out_of_standards); // If only one item, just print it
            }

            // Predict the water quality
            $quality = KNN::predict($temp, $ph, $turbidity, $tds);

            if(!in_array($prev_quality, ['', 'Bad', 'Very Bad']) && in_array($quality, ['Bad', 'Very Bad'])){
                $translated = '';

                if($quality == 'Bad'){
                    $translated = 'Buruk';
                } else if($quality == 'Very Bad'){
                    $translated = 'Sangat Buruk';
                }

                Warning::create([
                    'date_and_time' => $timestamp,
                    'message' => 'Terjadi penurunan kualitas air sungai ke tingkat <strong>"' . $translated .'"</strong>. Beberapa parameter seperti <strong>' . $sus_parameters . '</strong> diduga menyebabkan penurunan.',
                    'category' => $quality,
                ]);
            }

            $prev_quality = $quality;

            $sensorData[] = [
                'date_and_time' => $timestamp,

                'temp' => $temp,
                'ph' => $ph,
                'turbidity' => $turbidity,
                'tds' => $tds,

                'quality' => $quality,

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];

            GarbageDetection::create([
                'date_and_time' => $timestamp,
                'number' => $number_detected,
                'image_path' => (mt_rand(0, 1) == 0 ? 'example1.jpg' : 'example2.jpg')
            ]);
        }

        WaterQuality::insert($sensorData);

    }
}

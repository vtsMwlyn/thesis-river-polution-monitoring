<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Helpers\KNN;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
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

        $baseTimestamp = Carbon::now();
        $sensorData = [];

        for ($i = 0; $i < 1000; $i++) {
            // Subtract 5 minutes (300 seconds) for each iteration
            $timestamp = (clone $baseTimestamp)->subSeconds($i * 300);

            $temp += mt_rand(-5, 5);
            $ph += mt_rand(-20, 20) / 10; // Small float adjustment
            $turbidity += mt_rand(-30, 30) / 10; // Small float adjustment
            $tds += mt_rand(-50, 50);

            // Prevent negative values
            $temp = ($temp < 0) ? 0 : $temp;
            $ph = ($ph < 0) ? 0 : round($ph, 2);
            $turbidity = ($turbidity < 0) ? 0 : round($turbidity, 2);
            $tds = ($tds < 0) ? 0 : $tds;

            $sensorData[] = [
                'date_and_time' => $timestamp,

                'temp' => $temp,
                'ph' => $ph,
                'turbidity' => $turbidity,
                'tds' => $tds,

                'quality' => KNN::predict($temp, $ph, $turbidity, $tds),

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }

        WaterQuality::insert($sensorData);

    }
}

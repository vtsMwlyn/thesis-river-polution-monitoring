<?php

namespace App\Http\Controllers;

use App\Models\GarbageDetection;
use App\Models\Warning;
use Carbon\Carbon;
use App\Models\WaterQuality;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // Past 24 hours data
        $recent_sensor_data = WaterQuality::where('date_and_time', '>=', Carbon::now()->subDay())->latest()->first();
        $recent_warning = Warning::where('date_and_time', '>=', Carbon::now()->subDay())->latest()->get();
        $recent_detection = GarbageDetection::where('date_and_time', '>=', Carbon::now()->subDay())->latest()->first();

        // Render dashboard page with the data
        return view('dashboard', [
            'latest_sensor_data' => $recent_sensor_data,
            'all_warnings' => $recent_warning,
            'latest_detection' => $recent_detection,
        ]);
    }
}

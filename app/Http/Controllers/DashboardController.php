<?php

namespace App\Http\Controllers;

use App\Models\Warning;
use Carbon\Carbon;
use App\Models\WaterQuality;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // Past 24 hours data
        $recent_sensor_data = WaterQuality::where('date_and_time', '>=', Carbon::now()->subDay())->orderBy('date_and_time', 'asc')->get();

        // Past 24 hours warning
        $recent_warning = Warning::where('date_and_time', '>=', Carbon::now()->subDay())->latest()->get();

        // Map data for chart
        $labels = [];
        foreach($recent_sensor_data->pluck('date_and_time')->toArray() as $raw_date_time){
            $labels[] = Carbon::parse($raw_date_time)->format('H:i');
        }

        $temperature = $recent_sensor_data->pluck('temp')->toArray();
        $ph = $recent_sensor_data->pluck('ph')->toArray();
        $turbidity = $recent_sensor_data->pluck('turbidity')->toArray();
        $tds = $recent_sensor_data->pluck('tds')->toArray();

        $latest_measurement = $recent_sensor_data->first();

        return view('dashboard', [
            'all_sensor_data' => $recent_sensor_data,
            'latest_measurement' => $latest_measurement,
            'warnings' => $recent_warning,

            'labels' => $labels,
            'temp' => $temperature,
            'ph' => $ph,
            'turbidity' => $turbidity,
            'tds' => $tds,
        ]);
    }
}

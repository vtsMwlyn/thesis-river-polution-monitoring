<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\WaterQuality;
use Illuminate\Http\Request;

class PolutionController extends Controller
{
    public function index(){
        // Past 24 hours data
        $recent_sensor_data = WaterQuality::where('date_and_time', '>=', Carbon::now()->subDay())->orderBy('date_and_time', 'asc')->get();

        // Map data for chart
        $labels = [];
        foreach($recent_sensor_data->pluck('date_and_time')->toArray() as $raw_date_time){
            $labels[] = Carbon::parse($raw_date_time)->format('H:i');
        }

        $qualities = $recent_sensor_data->pluck('quality')->toArray();

        $temperature = $recent_sensor_data->pluck('temp')->toArray();
        $ph = $recent_sensor_data->pluck('ph')->toArray();
        $turbidity = $recent_sensor_data->pluck('turbidity')->toArray();
        $tds = $recent_sensor_data->pluck('tds')->toArray();

        return view('pages.polution.index', [
            'all_sensor_data' => $recent_sensor_data,

            'labels' => $labels,
            'qualities' => $qualities,

            'temp' => $temperature,
            'ph' => $ph,
            'turbidity' => $turbidity,
            'tds' => $tds,
        ]);
    }
}

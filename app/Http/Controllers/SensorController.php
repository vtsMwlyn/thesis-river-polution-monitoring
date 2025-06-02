<?php

namespace App\Http\Controllers;

use App\Helpers\KNN;
use App\Models\WaterQuality;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function index(){
        // Past 24 hours data
        $recent_sensor_data = WaterQuality::where('date_and_time', '>=', Carbon::now()->subDay())->orderBy('date_and_time', 'asc')->get();

        if(request('date') || request('starttime') || request('endtime')){
            $recent_sensor_data = WaterQuality::filter(request(['date', 'starttime', 'endtime']))->orderBy('date_and_time', 'asc')->get();
        }

        // Map data for chart
        $labels = [];
        foreach($recent_sensor_data->pluck('date_and_time')->toArray() as $raw_date_time){
            $labels[] = Carbon::parse($raw_date_time)->format('H:i');
        }

        $temperature = $recent_sensor_data->pluck('temp')->toArray();
        $ph = $recent_sensor_data->pluck('ph')->toArray();
        $turbidity = $recent_sensor_data->pluck('turbidity')->toArray();
        $tds = $recent_sensor_data->pluck('tds')->toArray();

        return view('pages.sensor.index', [
            'all_sensor_data' => $recent_sensor_data,

            'labels' => $labels,
            'temp' => $temperature,
            'ph' => $ph,
            'turbidity' => $turbidity,
            'tds' => $tds,
        ]);
    }

    public function destroy(WaterQuality $water_quality){
        $water_quality->delete();

        return back()->with('success', 'Successfully deleted the water quality data!');
    }
}

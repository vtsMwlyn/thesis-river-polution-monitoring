<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\GarbageDetection;

class DetectionController extends Controller
{
    public function index(){

        // Past 24 hours data
        $recent_detections = GarbageDetection::where('date_and_time', '>=', Carbon::now()->subDay())->orderBy('date_and_time', 'asc')->get();

        // Map data for chart
        $labels = [];
        foreach($recent_detections->pluck('date_and_time')->toArray() as $raw_date_time){
            $labels[] = Carbon::parse($raw_date_time)->format('H:i');
        }

        $garbage_detected = $recent_detections->pluck('number')->toArray();

        return view('pages.detection.index', [
            'all_detections' => $recent_detections,
            'labels' => $labels,
            'garbage_detected' => $garbage_detected,
        ]);
    }
}

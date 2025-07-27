<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\GarbageDetection;
use Illuminate\Support\Facades\Storage;

class DetectionController extends Controller
{
    public function index(){
        // Get Past 24 hours data
        $recent_detections = GarbageDetection::where('date_and_time', '>=', Carbon::now()->subDay())->orderBy('date_and_time', 'asc')->get();

        if(request('date') || request('starttime') || request('endtime')){
            $recent_detections = GarbageDetection::filter(request(['date', 'starttime', 'endtime']))->orderBy('date_and_time', 'asc')->get();
        }

        // Map data for chart
        $labels = [];
        foreach($recent_detections->pluck('date_and_time')->toArray() as $raw_date_time){
            $labels[] = Carbon::parse($raw_date_time)->format('H:i');
        }

        $garbage_detected = $recent_detections->pluck('number')->toArray();

        // Render detection page with the data
        return view('pages.detection.index', [
            'all_detections' => $recent_detections,
            'labels' => $labels,
            'garbage_detected' => $garbage_detected,
        ]);
    }

    // public function destroy(GarbageDetection $garbage_detection){
    //     Storage::disk('public')->delete($garbage_detection->image_path);

    //     $garbage_detection->delete();

    //     return back()->with('success', 'Successfully deleted the garbage detection data!');
    // }
}

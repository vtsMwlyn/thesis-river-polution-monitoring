<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function store_sensor_data(Request $request){
        if($request->secret == 'VTS_Meowlynna-2312'){
            return response()->json(['success' => true, 'message' => 'masuk']);
        }
        else {
            abort(401);
        }
    }

    public function store_detection_data(Request $request){
        if($request->secret == 'VTS_Meowlynna-2312'){
            return response()->json(['success' => true, 'message' => 'masuk']);
        }
        else {
            abort(401);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function index(){
        return view('pages.sensor.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolutionController extends Controller
{
    public function index(){
        return view('pages.polution.index');
    }
}

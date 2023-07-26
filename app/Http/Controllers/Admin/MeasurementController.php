<?php

namespace App\Http\Controllers\Admin;

use App\Models\Measurement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MeasurementController extends Controller
{
    //
    public function index(){
        $measurements = Measurement::orderBy('created_at', 'desc')->select('id', 'name')->get();
        responseData('data', $measurements, 200);
    }
    
}

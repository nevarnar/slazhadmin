<?php

namespace App\Http\Controllers\Admin;

use App\Models\UnitType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnitTypeController extends Controller
{
    //
    public function index(){
        $unit_types = UnitType::with('units')->orderBy('created_at', 'desc')->get();
        responseData('data', $unit_types, 200);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Models\PaymentType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentTypeController extends Controller
{
    //
    public function getPaymentType(Request $request){

        $payment_type= PaymentType::orderBy('id')->get();
        responseData('data',$payment_type,200);
    }
}

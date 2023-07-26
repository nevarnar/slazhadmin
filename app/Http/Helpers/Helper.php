<?php

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;

if (!function_exists('Model')) {
    function Model($model)
    {
        return Relation::getMorphedModel($model);
    }
}

if (!function_exists('UserData')) {
    function UserData()
    {
        //return  auth('api')->user();
        return (auth('web')->user()) ? : auth('sanctum')->user();
    }
}

if (!function_exists('CurrentTime')) {
    function CurrentTime()
    {
        return now()->format('Y-m-d H:i:s');
    }
}

if (!function_exists('JsonDecode')) {
    function JsonDecode($raw_data)
    {
        $input_items = stripslashes(str_replace(array('\"', '&quot;', '\n'), '', $raw_data));
        $json_data = json_decode($input_items);
        if ($json_data == null) {
            responseStatus('input data is not corrected', 402);
        }
        return $json_data;
    }
}

if (!function_exists('FirstWord')) {
    function FirstWord($code)
    {
        return intval(substr($code, 0, 1));
    }
}

if (!function_exists('UnsetData')) {
    function UnsetData($data, $attributes)
    {
        foreach ($attributes as $attribute) {
            unset($data[$attribute]);
        }
        return $data;
    }
}

if (!function_exists('RandomDigits')) {
    function RandomDigits()
    {
        return rand(1111, 9999);
    }
}

if (!function_exists('IntendedURL')) {
    function IntendedURL($request)
    {
        $request->session()->regenerate();
        return redirect()->intended('/default')->getTargetUrl();
    }
}

if (!function_exists('StrToDatabaseDate')) {
    function StrToDatabaseDate($str)
    {
        return date('Y-m-d', strtotime($str));
    }
}


if (!function_exists('GetGenderIds')) {
    function GetGenderIds($gender_id)
    {
        $gender_ids = [13]; //unisex gender id is 13
        if ($gender_id == 0) { //gender id 0(zero) is for all
            $gender_ids [] = 1;
            $gender_ids [] = 2;
        } else {
            $gender_ids [] = (int)$gender_id;
        }
        return $gender_ids;
    }
}

if (!function_exists('paginate')) {
    function paginate($data, $request)
    {
        return (new \App\Http\Actions\Paginate\paginate($data, $request))->run();
    }
}
if (!function_exists('convertDateFormat')) {
    function convertDateFormat($data)
    {
        return Carbon::parse($data)->format('Y-m-d');
    }
}


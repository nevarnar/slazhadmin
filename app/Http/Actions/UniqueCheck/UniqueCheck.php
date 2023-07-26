<?php

namespace App\Http\Actions\UniqueCheck;

use App\Models\DescriptionTranslation;
use App\Models\NameTranslation;

class UniqueCheck
{
    public function run($request, $type)
    {
        $input_data = JsonDecode($request->data);
        $model = NameTranslation::class;
        $unique_data = [];
        $id = $request->id;
        $check_data[] = ['name_translationable_type', $type];
        if ($id) {
            $check_data[] = ['name_translationable_id', '<>', $id];
        }

        foreach ($input_data as $data) {
            $exist_data = $model::with('name_translationable')->where($check_data)->where([
                ['name', $data->name],
                ['language_code', $data->language_code],
            ]) ->get();
            if ($exist_data) {
                foreach ($exist_data as $existed) {
                    if ($request->type === $existed->name_translationable->type) {
                        $error_category = new \stdClass();
                        $error_category->language_code = $existed->language_code;
                        $error_category->message = $existed->language_code . '_' . $type . ' is already exists.';
                        $unique_data[] = $error_category;
                    }
                }
            }


        }
        if (count($unique_data) > 0) {
            responseData('message', $unique_data, 422);
        }
    }

}

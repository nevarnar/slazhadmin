<?php

namespace App\Http\Actions\NameTranslation;

use App\Models\NameTranslation;

class NameSaving
{
    public function run($json_name_data, $model){
        foreach($json_name_data as $name){
            $this->detachName($model,[$name->language_code]);
            $name_translation = new NameTranslation();
            $name_translation->name = $name->name;
            $name_translation->language_code = $name->language_code;
            $model->name_translations()->save($name_translation);
        }
    }
    public function detachName($object,$languages){
        $object->name_translations()->whereIn('language_code',$languages)->delete();
    }
}

<?php

namespace App\Http\Actions\DescriptionTranslation;

use App\Models\DescriptionTranslation;

class DescriptionSaving
{
    public function run($json_name_data, $model){
        
        foreach($json_name_data as $name){
            $this->detachName($model,[$name->language_code]);
            $name_translation = new DescriptionTranslation();
            $name_translation->name = $name->name;
            $name_translation->language_code = $name->language_code;
            $model->description_translations()->save($name_translation);
        }

    }
    public function detachName($category,$languages){
        $category->description_translations()->whereIn('language_code',$languages)->delete();
    }

}

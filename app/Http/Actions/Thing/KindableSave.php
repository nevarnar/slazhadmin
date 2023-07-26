<?php

namespace App\Http\Actions\Thing;

class KindableSave
{
    public function run($model, $product)
    {
        $model->products()->save($product);
    }

    public function save_unstablemodel($models, $product_size)
    {
        $arrayIds = $this->getIdArray($models);
        $product_size->sync($arrayIds);
    }

    public function save($request, $model_array)
    {
        foreach ($model_array as $name) {
            
            $json_decode = json_decode($request->get($name['name']));
            
            // dd($json_decode);
            if (is_array($json_decode) && $name['name'] !== 'sub_variation') {
                if (!empty($json_decode)) {
                    $arrayIds = $this->getIdArray($json_decode);
                    
                    $name['function']->sync($arrayIds);
                } else {
                    $name['function']->detach();
                }
            } else if (is_object($json_decode)) {
                $name['function']->sync($json_decode->id);
            } else if ($name['name'] === 'sub_variation') {
                if (!empty($json_decode)) {
                    $sub_variation_ids=[];
                    foreach ($json_decode as $j) {
                        if($j->value!=null){
                            $sub_variation_ids[]= $j->value->name_translations[0]->name_translationable_id;
                        }
                       
                    }
                    if(count($sub_variation_ids)>0){
                        $name['function']->sync($sub_variation_ids);

                    }
                }
            }
        }
    }

    public function saveThings($model, $product)
    {
        return $model->save($product);
    }

    public function getIdArray($array)
    {
        foreach ($array as $a) {
            $ids[] = $a->id;
        }
        return $ids;
    }

}

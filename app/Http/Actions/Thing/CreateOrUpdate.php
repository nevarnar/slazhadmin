<?php

namespace App\Http\Actions\Thing;


use App\Http\Actions\DescriptionTranslation\DescriptionSaving;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\Thing\Product\CreateSize;
use App\Http\Actions\Thing\Product\Size;
use App\Models\Product;
use App\Models\Thing;

class CreateOrUpdate
{
    private $model;
    public function __construct($type){
        $this->model = Model($type);
    }

    public function run($request)
    {
        $created_model =  $this->update0rCreate($request);
        $thing = $this->saveThingable($request, $created_model, ['brand','series']);
        $this->saveTranslation($request,$created_model);
        (new CreateSize())->run($request,$thing);
    }

    public function update0rCreate($request)
    {
        //setData
        $data = $request->all();
        if (!isset($request->id)) {
            $data['id'] = null;
        }
        //createOrUpdateModel
       return $this->model::updateOrCreate(
            ['id' => $data['id']],
            $data
        );
    }

    public function saveThingable($request, $created_model, $kinds){
        #save things
        $thing =  isset($request->id) ? $created_model->thing : $created_model->thing()->save((new Thing()));
        # save model to productable table
        if ($thing) {
            $model_arr = $this->model_array( $thing, $kinds);
            (new KindableSave())->save($request, $model_arr);
        }
        return $thing;
    }

    protected function saveTranslation($request,$created_model )
    {
        #insert name translation
        $json_name_data = JsonDecode($request->data);
        (new NameSaving())->run($json_name_data, $created_model);
        #end

        # insert description translation
        $json_description_data = JsonDecode($request->description);
        (new DescriptionSaving())->run($json_description_data, $created_model);
        #end
    }

    protected function model_array($model , $kinds)
    {
        $model_arr = [
            ['name' => 'color', 'function' =>  $model->colors()],
            ['name' => 'occasion', 'function' => $model->occasions()],
            ['name' => 'tag', 'function' => $model->tags()],
            ['name' => 'gender', 'function' => $model->genders()],
            ['name' => 'season', 'function' => $model->seasons()],
        ];
       foreach ($kinds as $kind) {
           switch ($kind) {
               case 'brand' : case 'brands' :
               $model_arr [] =  ['name' => 'brands', 'function' => $model->brands()];
               break;
               case 'style_category' : case 'collection_category' :
               $model_arr [] =     ['name' => 'style_category', 'function' => $model->categories()];
               break;
               case 'sub_category' :
               $model_arr [] =     ['name' => 'sub_category', 'function' => $model->sub_categories()];
               break;
               case 'sub_variation' :
               $model_arr [] =     ['name' => 'sub_variation', 'function' => $model->sub_variations()];
               break;
               case 'series' :
               $model_arr [] =     ['name' => 'series', 'function' => $model->series()];
               break;
               case 'tax' :
               $model_arr [] =   ['name' => 'tax', 'function' => $model->taxes()];
               break;
               default :
           }
       }
       return $model_arr;
    }

}

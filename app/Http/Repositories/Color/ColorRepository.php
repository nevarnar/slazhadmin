<?php

namespace App\Http\Repositories\Color;

use App\Models\Color;

use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;

class ColorRepository implements ColorRepositoryInterface{

    private $select_data =  ['id', 'color_code', 'sku_name', 'icon','is_available'];

    public function listQuery($request)
    {
        $colors= Color::with('name_translations:id,name,language_code,name_translationable_id')->orderBy('created_at', 'desc')->select($this->select_data);
        if($request->search_input!=null || $request->search_input!=""){
            (new NameSearching())->searchName($colors,$request->search_input);
        }
        return $colors;
    }

    public function list($request){
        return $this->listQuery($request)->get();
    }

    public function availableList($request){
        return $this->listQuery($request)->whereIsAvailable(1)->get();

    }

    public function createOrUpdate($request)
    {
        $data = $request->all();
        if (isset($request->icon)) {
            $path = UploadImage($request, 'icon');
            $data['icon'] = $path;
            if(isset($request->id)){
                $color=Color::find($request->id);
                DeleteImage($color->icon);
            }
        }
        if(!isset($request->id)){
            $data['id'] = null ;
        }
        $color = Color::updateOrCreate(
            ['id'=> $data['id']],
            $data
        );
        $json_name_data = JsonDecode($request->data);
        (new NameSaving())->run($json_name_data,$color);
        return $this->details($color);
    }

    public function details(Color $color)
    {
        $color->name_translations = $color->name_translations;
        return $color;
    }

    public function delete(Color $color)
    {
        DeleteImage($color->icon);
        (new NameSaving())->detachName($color,['mm','en']);
        return $color->delete();
    }


}

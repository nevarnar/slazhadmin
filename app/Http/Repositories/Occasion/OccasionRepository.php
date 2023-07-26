<?php

namespace App\Http\Repositories\Occasion;

use App\Models\Occasion;

use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;

class OccasionRepository implements OccasionRepositoryInterface{
    
    private $select_data =  ['id', 'icon','is_available'];

    public function listQuery($request)
    {
        $occasions= Occasion::with('name_translations:id,name,language_code,name_translationable_id')->orderBy('created_at', 'desc')->select($this->select_data);
        if($request->search_input!=null || $request->search_input!=""){
            (new NameSearching())->searchName($occasions,$request->search_input);
        }
        return $occasions;
    }

    function list($request) {
        return $this->listQuery($request)->get();
    }
    function availableList($request) {
       return $this->listQuery($request)->whereIsAvailable(1)->get();
        
    }

    public function createOrUpdate($request)
    {
        $data = $request->all();
        if (isset($request->icon)) {
            $path = UploadImage($request, 'icon');
            $data['icon'] = $path;
            if(isset($request->id)){
                $get_photo=Occasion::find($request->id);
                DeleteImage($get_photo->icon);
            }
        }
        if(!isset($request->id)){
            $data['id'] = null ;
        }
        $occasion = Occasion::updateOrCreate(['id'=> $data['id']], $data);
        $json_name_data = JsonDecode($request->data);
        (new NameSaving())->run($json_name_data,$occasion);
        return $this->details($occasion);
    }
    public function details(Occasion $occasion)
    {
        $occasion->name_translations = $occasion->name_translations;
        return $occasion;
    }   
    public function delete(Occasion $occasion)
    {
        DeleteImage($occasion->icon);
        (new NameSaving())->detachName($occasion, ['mm', 'en']);
        return $occasion->delete();
    }

}

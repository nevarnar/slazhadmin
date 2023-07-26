<?php

namespace App\Http\Repositories\Delivery;

use App\Models\Delivery;
use App\Models\DeliveryMan;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;
use App\Http\Repositories\Delivery\DeliveryRepositoryInterface;

class DeliveryRepository implements DeliveryRepositoryInterface
{
    private array $select_data =  ['id','phone_number','delivery_id'];

    public function list($request){
        $delivery_men= DeliveryMan::with('name_translations:id,name,language_code,name_translationable_id')->orderBy('created_at', 'desc')->select($this->select_data);
        if($request->search_input!=null || $request->search_input!=""){
            (new NameSearching())->searchName($delivery_men,$request->search_input);
        }
        if($request->delivery_id){
            $delivery_men->where('delivery_id',$request->delivery_id);
        }
        return $delivery_men->get();
    }
    
    public function createOrUpdate($request){
        // dd($request->all());
        $data = $request->all();
        if(!isset($request->id)){
            $data['id'] = null ;
        }
         $delivery =  DeliveryMan::updateOrCreate(
            ['id'=> $data['id']],
            $data
        );
        $json_name_data = JsonDecode($request->data);
        (new NameSaving())->run($json_name_data,$delivery);
        return $this->getDetails($delivery->id);
    }
    
    public function delete($delivery_id){
        $dm=DeliveryMan::find($delivery_id);
        (new NameSaving())->detachName($dm,['mm','en']);
        return $dm->delete();
    }
    public function getDetails($delivery_id){
        return DeliveryMan::findOrfail($delivery_id);
    }
    public function getDelivery(){
        return Delivery::orderBy('id','desc')->get();
    }
    public function details(DeliveryMan $dm)
    {
        $dm->name_translations = $dm->name_translations;
        return $dm;
    }
}

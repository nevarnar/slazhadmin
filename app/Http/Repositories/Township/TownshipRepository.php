<?php

namespace App\Http\Repositories\Township;

use App\Models\Division;
use App\Models\Township;
use Illuminate\Support\Facades\DB;
use App\Http\Actions\NameTranslation\NameSaving;

class TownshipRepository implements TownshipInterface
{
    private $select_data=['id','division_id','delivery_fee','duration'];
    public function listQuery(){
        return Township::with(['name_translations:id,name,language_code,name_translationable_id',
        'division.name_translations:id,name,language_code,name_translationable_id'])
        ->orderBy('id', 'DESC')
        ->select($this->select_data);
    }

    public function list($request){
        $query=$this->listQuery();
        if ($request->division_id != null || $request->division_id != "") {
            $query->byDivision($request->division_id);
        }
        if($request->search_input!=null || $request->search_input!=""){
            $query->searchTownshipAndDivision($request->search_input);
        }
        return $query->get();
    }
    public function getTownships($request){
        $query=$this->listQuery();
        if ($request->division_id != null || $request->division_id != "") {
            $query->byDivision($request->division_id);
        }
        if($request->search_input!=null || $request->search_input!=""){
            $query->searchTownship($request->search_input);
        }   
        return $query->get();
    }
    public function getDivisions($request){
        return Division::orderBy('id')->get();
    }
    public function getTownshipByDivision($division_id){
        return $this->listQuery()->where('division_id',$division_id)->get();
    }
    public function createOrUpdate($request){
        $townships=JsonDecode($request->townships);
        DB::beginTransaction();
        try {
            foreach($townships as $t){
                Township::whereId($t->township_id)->update([
                    'duration'=>$request->duration,
                    'delivery_fee'=>$request->delivery_fee,
                ]);
            }            
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
    }

    public function update($request){
        DB::beginTransaction();
        try {
           
               Township::whereId($request->id)->update([
                    'delivery_fee'=>$request->delivery_fee,
                ]);
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
    }
    public function details($township){
        $township->division=$township->division;
        $township->name_translations=$township->name_translations;
        return $township;
    }
    public function delete($township){
        $township->delivery_fee=null;
        $township->save();
        return $township;
        // (new NameSaving())->detachName($township,['mm','en']);
        // return $township->delete();
    }
}

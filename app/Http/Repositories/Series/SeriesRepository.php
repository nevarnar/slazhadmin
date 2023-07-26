<?php

namespace App\Http\Repositories\Series;

use App\Models\Series;
use Illuminate\Support\Facades\DB;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;
use App\Http\Actions\ManyToManySaving\ManyToManySaving;
use App\Http\Repositories\Series\SeriesRepositoryInterface;

class SeriesRepository implements SeriesRepositoryInterface
{
    private array $select_data =  ['id','type','sub_category_id'];
    public function listQuery($request){
        $series= Series::orderBy('created_at', 'desc')->select($this->select_data);
        if($request->search_input!=null || $request->search_input!=""){
            (new NameSearching())->searchName($series,$request->search_input);
        }
        return $series;
    }
    public function list($request){
      
        return $this->listQuery($request)->get();
    }

    public function listWithType($request,$type){
        return $this->listQuery($request)->whereType($type)->get();
    }

    public function getProductSeries($request){
        $series= $this->listQuery($request)->whereType($request->type)
        ->whereSubCategoryId($request->sub_category_id);
        if($request->brand_id!=null || $request->brand_id !=""){
            $series->whereHas('brands',function($q)use($request){
                $q->where('brand_id',$request->brand_id);
            });
        }
        return $series->get();
    }
    
    public function createOrUpdate($request){
        // dd($request->brands);
        DB::beginTransaction();
        try{
        $data = $request->all();
        if(!isset($request->id)){
            $data['id'] = null ;
        }
         $series =  Series::updateOrCreate(
            ['id'=> $data['id']],
            $data
        );
        $json_name_data = JsonDecode($request->data);
        (new NameSaving())->run($json_name_data,$series);
        if($request->brands !=null || $request->brands !=""){
            $array=JsonDecode($request->brands);
            (new ManyToManySaving())->saveManytoMany($series->brands(),$array);
        }
        DB::commit();
    }catch(\Exception $e){
        DB::rollback();
        responseStatus($e->getMessage(),402);
        throw $e;
    }
        return $this->details($series);
    }
    
    public function details(Series $series)
    {
        $series->name_translations = $series->name_translations;
        $series->brand = $series->brand;
        $series->sub_category = $series->category;
        return $series;
    }
}

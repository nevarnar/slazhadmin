<?php

namespace App\Http\Repositories\Variation;

use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;
use App\Models\SubVariation;
use App\Models\Variation;
use Illuminate\Support\Facades\DB;

class VariationRepository implements VariationRepositoryInterface
{
    public function listQuery($request)
    {
        $variations = Variation::with(['name_translations:id,name,language_code,name_translationable_id', 'sub_variations', 'sub_categories'])->orderBy('created_at', 'desc');
        if ($request->search_input != null || $request->search_input != "") {
            (new NameSearching())->searchName($variations, $request->search_input);
        }
        return $variations;
    }

    function list($request) {
        return $this->adjustVariation($this->listQuery($request)->get());
    }
    public function availableList($request)
    {
        return $this->adjustVariation($this->listQuery($request)->whereIsAvailable(1)->get());

    }

    public function adjustVariation($variations)
    {
        foreach ($variations as $variation) {
            $sub_variation_data = array();
            foreach ($variation->sub_variations as $sub_variation) {
                array_push($sub_variation_data, array(
                    $sub_variation, $sub_variation->name_translations,
                ));
            }
            $variation->sub_variations = array($sub_variation_data);

            $sub_category_data = array();
            foreach ($variation->sub_categories as $sub_category) {
                array_push($sub_category_data, array(
                    $sub_category, $sub_category->name_translations,
                ));
            }
            $variation->sub_categories = $sub_category_data;
        }

        return $variations;
    }

    public function details(Variation $variation)
    {
        $variation->name_translations = $variation->name_translations;

        $sub_variation_data = array();
        foreach ($variation->sub_variations as $sub_variation) {
            array_push($sub_variation_data, array(
                "id" => $sub_variation->id,
                "name_translations" => $sub_variation->name_translations,
            ));
        }
        $variation->sub_variations = $sub_variation_data;

        $sub_category_data = array();
        foreach ($variation->sub_categories as $sub_category) {
            array_push($sub_category_data, array(
                "id" => $sub_category->id,
                "name_translations" => $sub_category->name_translations,
            ));
        }

        $variation->sub_categories = $sub_category_data;

        return $variation;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
        $variation = Variation::create();
        $sub_category_ids = json_decode($request->sub_category_ids);
        if(empty($sub_category_ids)){
            responseStatus('Sub Categories is empty',402);
        }
        foreach ($sub_category_ids as $sub_category_id) {
            $variation->sub_categories()->attach($sub_category_id);
        }
        $json_name_data = JsonDecode($request->data);
        (new NameSaving())->run($json_name_data, $variation);

        $sub_variations_name_data = json_decode($request->sub_variations);
        foreach ($sub_variations_name_data as $name_data) {
            $sub_variation = SubVariation::create(["variation_id" => $variation->id]);
            (new NameSaving())->run($name_data->names, $sub_variation);
        }
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        return $this->details($variation);
    }

    public function update(Variation $variation, $request)
    {
        DB::beginTransaction();
        try {
            $sub_category_ids = JsonDecode($request->sub_category_ids);
            $variation->sub_categories()->detach();
            foreach ($sub_category_ids as $sub_category_id) {
                $variation->sub_categories()->attach($sub_category_id);
            }
            $json_name_data = JsonDecode($request->data);
            (new NameSaving())->run($json_name_data, $variation);

            foreach ($variation->sub_variations as $sub_variation) {
                (new NameSaving())->detachName($sub_variation, ['mm', 'en']);
                // $sub_variation->delete();
            }

            $sub_variations_name_data = JsonDecode($request->sub_variations);
            foreach ($sub_variations_name_data as $name_data) {
                if ($name_data->id != null) {
                    $sub_variation = SubVariation::find($name_data->id);
                    (new NameSaving())->run($name_data->names, $sub_variation);
                } else {
                    $sub_variation = SubVariation::create(["variation_id" => $variation->id]);
                    // (new NameSaving())->run($name_data->names, $sub_variation);
                }
                (new NameSaving())->run($name_data->names, $sub_variation);
            }
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        return $this->details($variation);
    }
    
    public function variationBySubCategory($id)
    {
        $variations = Variation::has('sub_variations')->with(['name_translations:id,name,language_code,name_translationable_id', 'sub_variations.name_translations', 'sub_categories.unit_types.sizes', 'sub_categories', 'sub_categories.measurements', 'sub_categories.units'])
            ->whereRelation('sub_categories', 'sub_category_id', $id)
            ->where('is_available',1)
            ->orderBy('created_at', 'desc')
            ->get();
            $a=[];
            // foreach($variations as $v){
            // //    if($v->sub_variations){
            //     $a[]=$v->sub_variations;
            // //    }
            // }
            $variations=$variations->filter(function($v){
                return $v->sub_variations()->exists();
            });
            // dd($a);
        return $variations;
    }

    public function delete(Variation $variation)
    {
        foreach ($variation->sub_variations as $sub_variation) {
            (new NameSaving())->detachName($sub_variation, ['mm', 'en']);
            $sub_variation->delete();
        }

        (new NameSaving())->detachName($variation, ['mm', 'en']);
        return $variation->delete();
    }
}

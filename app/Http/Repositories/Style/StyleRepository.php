<?php

namespace App\Http\Repositories\Style;

use App\Http\Actions\CurrentFlashSale;
use App\Http\Actions\Listing\ProductListing;
use App\Http\Actions\Listing\StyleDetails;
use App\Http\Actions\Listing\StyleDiscount;
use App\Http\Actions\Listing\StyleListing;
use App\Http\Actions\Paginate\paginate;
use App\Models\Discount;
use App\Models\Style;
use App\Models\Thing;
use Illuminate\Support\Facades\DB;
use App\Http\Actions\Thing\KindableSave;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\DescriptionTranslation\DescriptionSaving;
use App\Http\Actions\NameTranslation\NameSearching;
use App\Models\StyleName;
use App\Models\StylePhoto;
use stdClass;

class StyleRepository implements StyleRepositoryInterface
{
    public function listQuery($request)
    {
        return Style::with('name_translations', 'description_translations', 'thing.series', 'thing.brands', 'thing.categories')->orderBy('id', 'desc')
            ->getType($request->type);
    }

    public function list($request)
    {
        $data = $this->listQuery($request);
        if ($request->search_input != null || $request->search_input != "") {
            (new NameSearching())->searchName($data, $request->search_input);
        }
        return $data->get();

        //    if($request->search_input!=null || $request->search_input!=""){
        //     (new NameSearching())->searchName($styles,$request->search_input);
        //    }
        //     if($request->series !=null || $request->series != ""){
        //         $styles->whereHas('thing.series',function($q)use($request){
        //             $q->where('kindable_id',$request->series);
        //         });
        //     }
        //     return $styles->get();
    }

    public function availableList($request)
    {
        $data = $this->listQuery($request)->isAvailable(1);
        if ($request->search_input != null || $request->search_input != "") {
            (new NameSearching())->searchName($data, $request->search_input);
        }
        return $data->get();
    }

    public function createOrUpdate($request)
    {
        $data = $request->all();
        #test
        if (!isset($request->id)) {
            $data['id'] = null;
        }
        DB::beginTransaction();
        try {
            #style create
            $style = Style::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
            #end style create

            //*product style
            if(!isset($request->id)){
                $products = JsonDecode($request->products);
                    foreach($products as $p){
                        // $syncData[$p->product_id]['color_id']=new stdClass();
                        // $syncData[$p->product_id]['color_id'] =$p->color_id;
                        // $product_ids[]=$p->product_id;
                        // $color_ids[]=$p->color_id;
                        $style->products()->attach($p->product_id,['color_id'=>$p->color_id]);
                    }
                    // $style->products()->sync($syncData);
                    // dd($product_ids);
                    // dd($syncData);
                // $style->products()->syncWithPivotValues($product_ids,$color_ids);
            }
            //*end

            #save things
            $thing = isset($request->id) ? $style->thing : $style->thing()->save((new Thing()));
            #end

            # save model to kindable table
            if ($thing) {
                $model_arr = $this->model_array($thing);
            }
            (new KindableSave())->save($request, $model_arr);
            #end

            #insert name translation
            $json_name_data = JsonDecode($request->data);
            (new NameSaving())->run($json_name_data, $style);
            // $brand=Brand::find(json_decode($request->brand)->id);
            #end

            # insert description translation
            $json_description_data = JsonDecode($request->description);
            (new DescriptionSaving())->run($json_description_data, $style);
            #end
            #insert style photo
            if (isset($request->photo)) {
                $photo = UploadImage($request, 'photo');
                if (isset($request->id)) {
                    $old_photos = (new StylePhoto())->getStylePhoto($style->id, 'feature_photo');
                    DeleteOldPhoto($old_photos);
                    (new StylePhoto())->deleteStylePhoto($style->id, 'feature_photo');
                }
                $style->createStylePhoto([
                    'name' => $photo,
                    'type' => 'feature_photo'
                ]);
            }
            if (isset($request->gallery)) {
                $photos = MultipleUploadImage($request, 'gallery');
                // if (isset($request->id)) {
                //     $old_photos=(new StylePhoto())->getStylePhoto($style->id,'gallery');
                //         DeleteOldPhoto($old_photos);
                //     (new StylePhoto())->deleteStylePhoto($style->id,'gallery');
                // }
                foreach ($photos as $photo) {
                    $style->createStylePhoto([
                        'name' => $photo,
                        'type' => 'gallery'
                    ]);
                }
            }
            #end
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        return $this->details($style);
    }

    public function details($style)
    {
        $style->name_translations = $style->name_translations;
        $style->description_translations = $style->description_translations;
        $style->series = $style->thing->series;
        $style->brands = $style->thing->brands;
        $style->colors = $style->thing->colors;
        $style->style_names = $style->thing->stylists;
        $style->genders = $style->thing->genders;
        $style->seasons = $style->thing->seasons;
        $style->occasions = $style->thing->occasions;
        $style->categories = $style->thing->categories;
        $style->tags = $style->thing->tags;
        $style->products   =$style->products;
        foreach($style->products as $p){
            $p->colors=$p->thing->colors->filter(function($c)use($p){
                return $c->id==$p->pivot->color_id;
            })->values();
            $p->sub_product=$p->sub_products->filter(function($s)use($p){
                return $s->color_id==$p->pivot->color_id;
            })->values();
            $p->sizes=$p->thing->sizes;
            $p->sub_categories=$p->thing->sub_categories;
            $p->brands=$p->thing->brands;
            foreach($p->sub_product as $sub){
                // $p->product_prices=$sub->product_prices->price;
            }
            UnsetData($p,['thing','sub_products']);
        }
        $style->stylists   =$style->thing->stylists;
        $style->style_photos=$style->style_photos;
        return $style;
    }

    public function model_array($model)
    {
        return [
            ['name' => 'brands', 'function' => $model->brands()],
            ['name' => 'color', 'function' => $model->colors()],
            ['name' => 'occasion', 'function' => $model->occasions()],
            // ['name' => 'style_name', 'function' => $model->style_names()],
            ['name' => 'gender', 'function' => $model->genders()],
            ['name' => 'season', 'function' => $model->seasons()],
            ['name' => 'style_category', 'function' => $model->categories()],
            ['name' => 'series', 'function' => $model->series()],
            ['name' => 'stylist', 'function' => $model->stylists()],
            ['name' => 'tag', 'function' => $model->tags()],
        ];
    }

    //mobile API
    public function getStyleListByGenderId($request)
    {
        $gender_id = $request->gender_id;
        $is_feature = $request->is_feature;
        $styles = [];
        $gender_ids = GetGenderIds($gender_id);
        $raw_query  = Style::with('name_translations', 'products:price');
        if($is_feature){
            $style_count = 10;
            $raw_query->where('is_feature',$is_feature)
                ->take($style_count);
        }
        $raw_styles  =   $raw_query->select('id')
            ->orderBy('id', 'desc')
            ->where([['type', 'style'], ['is_available', true]])
            ->WhereHas('thing.genders', function ($query) use ($gender_ids) {
                $query->whereIn('id', $gender_ids);
            })
            ->get();
        foreach ($raw_styles as $style) {
            $styles [] = (new StyleListing())->card($style);
        }
        return $styles;
    }


    public function getStyleDetails($style_id)
    {
        return (new StyleDetails())->run($style_id);
    }

    public function styleNameList()
    {
        return StyleName::with('name_translations:id,name,language_code,name_translationable_id')->select(['id'])->orderBy('created_at', 'desc')->get();
    }

    public function createStyleName($request)
    {
        $data = $request->all();
        $style_name = StyleName::create(
            $data
        );
        $json_name_data = JsonDecode($request->data);
        (new NameSaving())->run($json_name_data, $style_name);
        return $this->styleNameList();
    }

}

<?php

namespace App\Http\Repositories\Collection;

use App\Http\Actions\Listing\CollectionListing;
use App\Http\Actions\Listing\ProductListing;
use App\Http\Actions\Listing\Style;
use App\Http\Actions\Listing\StyleListing;
use App\Http\Actions\Paginate\paginate;
use stdClass;
use App\Models\Thing;
use App\Models\Collection;
use App\Models\CollectionPhoto;
use Illuminate\Support\Facades\DB;
use App\Http\Actions\Thing\KindableSave;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;
use App\Http\Actions\DescriptionTranslation\DescriptionSaving;

class CollectionRepository implements CollectionRepositoryInterface
{
    public function list($request)
    {
        $collections = Collection::with('name_translations', 'description_translations', 'thing.brands', 'thing.categories', 'styles')->sort('id');
        if ($request->search_input != null || $request->search_input != "") {
            (new NameSearching())->searchName($collections, $request->search_input);
        }
        return $collections->get();
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
            #Collection create
            $collection = Collection::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
            #end Collection create
            //*save styles at Collection
            $styles = json_decode($request->styles);
            if (!empty($styles)) {
                foreach ($styles as $p) {
                    $syncData[] = $p->style_id;
                }
                $collection->styles()->sync($syncData);
            }
            //*end

            //*save products at Collection
            $products = json_decode($request->products);
            if (!empty($products)) {
                foreach ($products as $p) {
                    $syncProducts[] = $p->product_id;
                }
                $collection->products()->sync($syncProducts);
            }

            //*end

            #save things
            $thing = isset($request->id) ? $collection->thing : $collection->thing()->save((new Thing()));
            #end

            # save model to kindable table
            if ($thing) {
                $model_arr = $this->model_array($thing);
            }
            (new KindableSave())->save($request, $model_arr);
            #end

            #insert name translation
            $json_name_data = JsonDecode($request->data);
            (new NameSaving())->run($json_name_data, $collection);
            // $brand=Brand::find(json_decode($request->brand)->id);
            #end

            # insert description translation
            $json_description_data = JsonDecode($request->description);
            (new DescriptionSaving())->run($json_description_data, $collection);
            #end

            #insert Collection photo
            if (isset($request->photo)) {
                $photo = UploadImage($request, 'photo');
                if (isset($request->id)) {
                    $old_photos = (new CollectionPhoto())->getCollectionPhoto($collection->id);
                    DeleteOldPhoto($old_photos);
                    (new CollectionPhoto())->deleteCollectionPhoto($collection->id);
                }
                $collection->createCollectionPhoto([
                    'name' => $photo,
                ]);
            }
            #end
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        return $this->details($collection);
    }

    public function model_array($model)
    {
        return [
            ['name' => 'color', 'function' => $model->colors()],
            ['name' => 'brands', 'function' => $model->brands()],
            ['name' => 'occasion', 'function' => $model->occasions()],
            ['name' => 'tag', 'function' => $model->tags()],
            ['name' => 'gender', 'function' => $model->genders()],
            ['name' => 'season', 'function' => $model->seasons()],
            ['name' => 'collection_category', 'function' => $model->categories()],
        ];
    }

    public function details($collection)
    {
        $collection->name_translations = $collection->name_translations;
        $collection->description_translations = $collection->description_translations;
        $collection->collection_photo = $collection->collection_photo;
        $collection->thing->brands = $collection->thing->brands;
        $collection->colors = $collection->thing->colors;
        $collection->tags = $collection->thing->tags;
        $collection->genders = $collection->thing->genders;
        $collection->seasons = $collection->thing->seasons;
        $collection->occasions = $collection->thing->occasions;
        $collection->categories = $collection->thing->categories;
        // $collection->sub_products = $collection->thing->sub_products;
        // $collection->sub_category = $collection->thing->sub_products->product->thing->sub_categories;
        $collection->styles = $collection->styles;
        $collection->products = $collection->products;
        return $collection;
    }

    public function destroy($collection){
        // DB::transaction(function () use ($collection) {
            (new NameSaving())->detachName($collection,['mm','en']);
            (new DescriptionSaving())->detachName($collection,['mm','en']);
            $collection->delete();
        // });
    }

    public function getListByGender($request)
    {
        $gender = $request->gender_id;
        $is_feature = $request->is_feature;
        $gender_ids = GetGenderIds($gender);
        $query = Collection::with('name_translations', 'description_translations');
        if($is_feature){
            $collection_count = 3;
            $query->where('is_feature',$is_feature)
                ->take($collection_count);
        }
        $collections =  $query
            ->select('id')
            ->orderBy('id', 'desc')
            ->WhereHas('thing.genders', function ($query) use ($gender_ids) {
                $query->whereIn('id', $gender_ids);
            })
        ->get();
        foreach ($collections as $collection) {
            $collection->feature_photo = $collection->collection_photo->name;
            UnsetData($collection, ['thing', 'collection_photo']);
        }
        return $collections;
    }

    public function collectionDetail($collection_id, $request)
    {
        $collection = (new CollectionListing())->getCollectionById($collection_id, ['name_translations', 'description_translations', 'collection_photo']);
        return UnsetData($collection, ['thing', 'products', 'styles']);
    }

    public function getProductsByCollection($collection_id, $request)
    {
        $collection = (new CollectionListing())->getCollectionById($collection_id, ['products', 'products.thing.colors', 'thing.sub_products']);
        $collection_products = $collection->products;
        $products = [];
        foreach ($collection_products as $product){
            $col_product = (new ProductListing())->card($product);
            $products[] = $col_product;
        }
        return paginate($products,$request);
    }

    public function getStylesByCollection($collection_id, $request)
    {
        $collection = (new CollectionListing())->getCollectionById($collection_id, ['styles', 'styles.feature_photos', 'thing.sub_products']);
        $collection_styles = $collection->styles;
        $styles = [];
        foreach ($collection_styles as $col_style) {
            $col_style = (new StyleListing())->card($col_style);
            $styles [] = $col_style;
        }
        return paginate($styles, $request);
    }
}

<?php

namespace App\Http\Repositories\Product;

use App\Models\Size;
use App\Models\Color;
use App\Models\Thing;
use App\Models\Product;
use App\Models\StylePhoto;
use App\Models\ProductPhoto;
use App\Models\SubVariation;
use App\Models\CollectionPhoto;
use App\Models\SubProductPhoto;
use Illuminate\Support\Facades\DB;
use App\Http\Actions\Thing\KindableSave;
use App\Http\Actions\Listing\ProductDetails;
use App\Http\Actions\Listing\ProductListing;
use App\Http\Actions\Listing\SubProductDetails;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;
use App\Http\Actions\DescriptionTranslation\DescriptionSaving;

class ProductRepository implements ProductRepositoryInterface
{
    private $select_data = ['id', 'price', 'sku', 'is_available'];

    function list($request)
    {
        $products = Product::with(['name_translations', 'description_translations', 'thing.series', 'thing.sizes', 'thing.colors', 'thing.brands', 'thing.taxes', 'thing.occasions', 'thing.genders', 'thing.sub_categories', 'thing.sub_variations', 'sub_products',
            'sub_products.product.sub_product_photos', 'thing.tags', 'product_photos', 'thing.seasons'])->orderBy('created_at', 'desc')->select($this->select_data);
         if ($request->search_input != null || $request->search_input != "") {
            (new NameSearching())->searchName($products, $request->search_input);
        }
        if ($request->series != null || $request->series != "") {
            $products->whereHas('thing.series', function ($q) use ($request) {
                $q->where('kindable_id', $request->series);
            });
        }
        return $products->get();
    }

    public function listWhenIsAvailableTrue()
    {
        return Product::with('name_translations')->sort('id')->whereIsAvailable(true)->get();
    }

    public function createOrUpdate($request)
    {
        $data = $request->all();
        if (!isset($request->id)) {
            $data['id'] = null;
        }
        $images = $request->file('sub_product_images');
        $sub = [];
        foreach (json_decode($request->sub_product) as $sub_product) {
            #sub product image
            if ($sub_product->last_color_sub_product == true && $images != null) {
                foreach ($images as $image) {
                    $sub_image = $image->getClientOriginalName();

                    $sub_product->images->front_view === $sub_image ?
                        $sub_product->front_view_photo = $image : null;

                    $sub_product->images->back_view === $sub_image ?
                        $sub_product->back_view_photo = $image : null;

                    $sub_product->images->side_view === $sub_image ?
                        $sub_product->side_view_photo = $image : null;

                    $sub_product->images->something_view === $sub_image ?
                        $sub_product->something_view_photo = $image : null;
                }
                $sub[] = $sub_product;
            }
        }
        DB::beginTransaction();
        try {
            #product create
            $product = Product::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
            #end product create

            #save things
            $thing = isset($request->id) ? $product->thing : $product->thing()->save((new Thing()));
            #end

            # save model to productable table
            if ($thing) {
                $model_arr = $this->model_array($thing);
                (new KindableSave())->save($request, $model_arr);
            }
            #end

            #insert name translation
            $json_name_data = JsonDecode($request->data);
            (new NameSaving())->run($json_name_data, $product);
            // $brand=Brand::find(json_decode($request->brand)->id);
            #end

            # insert description translation
            $json_description_data = JsonDecode($request->description);
            (new DescriptionSaving())->run($json_description_data, $product);
            #end

            # insert size to productable
            if ($request->isNumbering === "true") {
                $sizes = explode(",", $request->size);
                foreach ($sizes as $s) {
                    $size[] = Size::firstOrCreate(
                        ['name' => $s],
                        ['unit_type_id' => 1]
                    );
                }
                (new KindableSave())->save_unstablemodel($size, $thing->sizes());
            } else {
                $model_arr = [['name' => 'size', 'function' => $thing->sizes()]];
                (new KindableSave())->save($request, $model_arr);
            }

            #insert product photo

            if (isset($request->photo)) {
                $photo = UploadImage($request, 'photo');
                if (isset($request->id)) {
                    $old_photos = (new ProductPhoto())->getProductPhoto($product->id, 'photo');
                    if($old_photos->isEmpty()){
                        $product->createProductPhoto([
                            'name' => $photo,
                            'type' => 'photo',
                            'color_id' => null,
                        ]);
                    }else{
                        DeleteOldPhoto($old_photos);
                        $product->updateProductPhoto([
                            'name' => $photo,
                        ], 'photo');
                    }

                } else {
                    $product->createProductPhoto([
                        'name' => $photo,
                        'type' => 'photo',
                        'color_id' => null,
                    ]);
                }
            }

            #end

            // insert sub product
            if ($product->id) {
                $images = $request->file('sub_product_images');
                foreach (json_decode($request->sub_product) as $sub_product) {
                    #insert sub product image
                    if ($sub_product->last_color_sub_product == true && $images != null) {
                        foreach ($images as $image) {
                            $sub_image = $image->getClientOriginalName();
                            if ($sub_product->images->front_view === $sub_image) {
                                $sub_product->front_view_photo = $image;
                            }
                            if ($sub_product->images->back_view === $sub_image) {
                                $sub_product->back_view_photo = $image;
                            }
                            if ($sub_product->images->side_view === $sub_image) {
                                $sub_product->side_view_photo = $image;
                            }
                            if ($sub_product->images->something_view === $sub_image) {
                                $sub_product->something_view_photo = $image;
                            }
                        }
                        $types = ['front_view', 'back_view', 'side_view', 'something_view'];
                        foreach ($types as $type) {
                            $is_update = 'is_' . $type . '_update';
                            $photo_label = $type . '_photo';
                            $id = $type . '_id';
                            if ($sub_product->images->$type != null) {

                                $photo=StoreImage($sub_product->$photo_label);
                                // $photo = basename($sub_product->$photo_label->store('images', 's3'));

                                if ($sub_product->images->$is_update == true) {
                                    if ($request->id) {
                                        if(isset($sub_product->images->$id)){
                                            $sub_product_photos = (new SubProductPhoto())->getSubProductPhotoById($sub_product->images->$id);
                                        } else {
                                            $sub_product_photos = (new SubProductPhoto())->getSubProductPhoto($product->id, $type, $sub_product->color->id);
                                        }
                                        // $sub_product_photos = (new SubProductPhoto())->getSubProductPhotoById($sub_product->images->$id);
                                        if ($sub_product_photos->isEmpty()) {
                                            $product->createSubProductPhoto([
                                                'name' => $photo,
                                                'type' => $type,
                                                'color_id' => $sub_product->color->id,
                                            ]);
                                        } else {
                                            if ($sub_product_photos->count() <= 1) {
                                                DeleteOldPhoto($sub_product_photos);
                                            }
                                            $product->updateSubProductPhoto([
                                                'name' => $photo,
                                                'type' => $type,
                                                'color_id' => $sub_product->color->id,
                                            ], $type, $sub_product->color->id);
                                        }
                                    }
                                } else {
                                    $product->createSubProductPhoto([
                                        'name' => $photo,
                                        'type' => $type,
                                        'color_id' => $sub_product->color->id,
                                    ]);
                                }
                            }
                        }

                    }
                    #end sub product image insert
                    $size = $request->isNumbering ? Size::where('name', $sub_product->size->name)->first() : Size::find($sub_product->size->id);
                    $sub_product_id = isset($request->id) ? $sub_product->id : null;
                    $sku = JsonDecode($request->brand)->sku_name . "-" . JsonDecode($request->sub_category)->sku_name . "-" . $sub_product->color->sku_name . "-" . $size->name;
                    $created_sub_product = $product->createSubProduct([
                        'sku' => $sku,
                        'size_id' => $size->id,
                        'color_id' => $sub_product->color->id,
                        'is_available' => $sub_product->available,
                    ], $sub_product_id);
                    if (isset($sub_product->price)) {
                        $created_sub_product->createProductPrice([
                            'price' => $sub_product->price,
                        ]);
                    }
                }
            }
            #end insert sub product
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        return $this->details($product);
    }
    public function model_array($model)
    {
        return [
            ['name' => 'color', 'function' => $model->colors()],
            ['name' => 'brand', 'function' => $model->brands()],
            ['name' => 'occasion', 'function' => $model->occasions()],
            ['name' => 'sub_category', 'function' => $model->sub_categories()],
            ['name' => 'tag', 'function' => $model->tags()],
            ['name' => 'gender', 'function' => $model->genders()],
            ['name' => 'season', 'function' => $model->seasons()],
            ['name' => 'tax', 'function' => $model->taxes()],
            ['name' => 'sub_variation', 'function' => $model->sub_variations()],
            ['name' => 'series', 'function' => $model->series()],
        ];
    }

    public function details(Product $product)
    {
        $product->all_sizes = (new Size())->list();
        $product->all_colors = (new Color())->list();
        foreach ($product->thing->sub_variations as $sv) {
            $sv->variation->sub_variations = (new SubVariation())->whereById('variation_id', $sv->variation_id);
        }
        #end
        $product->name_translations = $product->name_translations;
        $product->description_translations = $product->description_translations;
        $product->size_guide = $product->size_guide;
        $product->sizes_by_sub_products = $product->thing->sizes;
        $product->colors_by_sub_products = $product->thing->colors;
        $product->series = $product->thing->series;
        $product->brands = $product->thing->brands;
        $product->taxes = $product->thing->taxes;
        $product->genders = $product->thing->genders;
        $product->seasons = $product->thing->seasons;
        $product->occasions = $product->thing->occasions;
        $product->sub_categories = $product->thing->sub_categories;
        $product->tags = $product->thing->tags;
        $product->sub_variations = $product->thing->sub_variations;
        $product->sub_products = $product->sub_products;
        $product->product_photos = $product->product_photos;
        $product->sub_product_photos = $product->sub_product_photos;
        return $product;
    }

    public function getSubProductByProduct($product)
    {
        foreach ($product->sub_products as $sub_product) {
            foreach ($sub_product->product->sub_product_photos as $photo) {
                if ($sub_product->color->id == $photo->color_id) {
                    $sub_product->photo = $photo;
                }
            }
        }
        return $product;
    }

    public function availableSizeByProductAndColor($product_id, $color_id)
    {
        $product = Product::with('name_translations', 'thing.brands', 'thing.sub_categories', 'sub_products.product_prices')
            ->whereSubProductColorId($color_id)->whereThingColorId($color_id)
            ->whereId($product_id)
            ->get();
        $available_sizes = [];
        foreach ($product[0]->sub_products as $sub) {
            $product[0]->sub_product_pirce = $sub->product_prices;
            $available_sizes[] = $sub->size;
        }
        $product[0]->sizes = $available_sizes;
        return $product;
    }

    public function getProductBySubCategory($id)
    {
        $products = Product::with(['name_translations'])->select(['id', 'price'])
            ->whereCategoryId($id)
            ->get();
        return $products;
    }

    public function deleteOldPhoto($photos)
    {
        if ($photos->isNotEmpty()) {
            foreach ($photos as $photo) {
                DeleteImage($photo->name);
            }
        }
    }

    public function deletePhoto($request)
    {
        switch ($request->type) {
            case 'style':
                StylePhoto::find($request->id)->delete();
                break;
            case 'collection':
                CollectionPhoto::find($request->id)->delete();
                break;
            default:
                ProductPhoto::find($request->id)->delete();
                break;
        }
    }

    //mobile API

    public function getProductDetail($product_id){
        return (new ProductDetails())->run($product_id);
    }

    public function getSubProductDetail($sub_product_id){
        return (new SubProductDetails())->run($sub_product_id);
    }



    public function setProductData($products)
    {
        $user = UserData();
        foreach ($products as $product) {
            $available_colors = (new ProductListing())->getAvailable_colors($product);
            UnsetData($product, ['thing', 'product_photo', 'pivot', 'updated_at', 'created_at', 'is_available', 'sku']);
            $product->avaliable_colors = $available_colors;
            $product->is_already_favourite = $user->favouriteProducts->contains($product->id);
        }
        return $products;
    }

    public function getProductBySeriesAndBrand($request){
        $things=Thing::with(['series','brands'])->where('thingable_type',$request->type)->get();
        $data=[];
        foreach($things as $thing){
            $cat=$request->promotion_type=='series' ?$thing->series :$thing->brands;
           foreach($cat as $c){
            array_push($data,$c);
           }
        }
        return collect($data)->unique('id');
    }

}

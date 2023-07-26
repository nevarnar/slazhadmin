<?php

namespace App\Http\Repositories\Filter;

use App\Http\Actions\Listing\ProductListing;
use App\Http\Actions\Listing\StyleListing;
use App\Http\Actions\Product\SubCategories;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\Season;
use App\Models\Size;
use App\Models\Style;
use App\Models\SubCategory;
use App\Models\SubVariation;
use App\Models\Thing;
use Illuminate\Support\Facades\DB;

class FilterRepository implements FilterInterface
{
    public function getFilterData($request)
    {
        $sub_category_id = $request->sub_category_id;
        $type_ids = $this->getThingIdsByType($sub_category_id, $request->type);
        $brand_ids = $this->getKindsByProducts($type_ids, 'brand');
        $color_ids = $this->getKindsByProducts($type_ids, 'color');
        $size_ids = $this->getKindsByProducts($type_ids, 'size');
        $sub_variation_ids = $this->getKindsByProducts($type_ids, 'sub_variation');
        $season_ids = $this->getKindsByProducts($type_ids, 'season');
        $occasion_ids = $this->getKindsByProducts($type_ids, 'occasion');
        $brands = Brand::whereIn('id', $brand_ids)->select('id')->get();
        $sizes = Size::whereIn('id', $size_ids)->select('id', 'name')->get();
        $colors = Color::whereIn('id', $color_ids)->select('id', 'icon')->get();
        $sub_variations = SubVariation::whereIn('id', $sub_variation_ids
        )->select('id', 'variation_id')->get();
        $sub_variations_by_variation = collect($sub_variations)->groupBy('variation_id')->values();
        $variations_with_sub = [];
        foreach ($sub_variations_by_variation as $sub_variations) {
            $sub_var = new \stdClass();
            $sub_var->variation = $sub_variations[0]->variation;
            foreach ($sub_variations as $sub_variation) {
                UnsetData($sub_variation, ['variation']);
            }
            $sub_var->sub_variations = $sub_variations;

            $variations_with_sub [] = $sub_var;
        }
        $seasons = Season::whereIn('id', $season_ids)->select('id', 'name')->get();
        $occasions = Occasion::whereIn('id', $occasion_ids)->select('id')->get();
        $data = new \stdClass();
        $data->brands = $brands;
        $data->colors = $colors;
        $data->seasons = $seasons;
        $data->occasions = $occasions;
        if ($request->type == 'product') {
            $data->sizes = $sizes;
            $data->price_range = $this->setPriceRange();
            $data->variation_data = $variations_with_sub;
        }
        return $data;
    }

    protected function getThingIdsByType($sub_category_id, $type)
    {
        if ($type == 'product') {
            $sub_category_ids = ($sub_category_id == null) ? $this->getAllSubCategoryIds() : [$sub_category_id];
            return $this->getProductsBySubCategory($sub_category_ids);
        }
        return Thing::where('thingable_type', $type)->pluck('thingable_id');
    }

    protected function getAllSubCategoryIds(){
        return SubCategory::all()->pluck('id');
    }

    protected function getProductsBySubCategory($sub_category_ids)
    {
        return DB::table('kindables')
            ->join('things', function ($join) {
                $join->on('things.thingable_id', '=', 'kindables.thing_id')
                    ->where('things.thingable_type', '=', 'product');
            })
            ->where('kindable_type', 'sub_category')
            ->whereIn('kindable_id', $sub_category_ids)
            ->distinct('thing_id')
            ->pluck('thing_id');
    }

    protected function getKindsByProducts($product_ids, $kind_type)
    {
        return DB::table('kindables')
            ->where('kindable_type', $kind_type)
            ->whereIn('thing_id', $product_ids)
            ->pluck('kindable_id');
    }

    protected function setPriceRange()
    {
        $price_range = [];
        $price_one = new \stdClass();
        $price_one->id = 0;
        $price_one->min = 0;
        $price_one->max = 500000;
        $price_one->name = '0-500000';
        $price_range [] = $price_one;
        $price_two = new \stdClass();
        $price_two->id = 1;
        $price_two->min = 500000;
        $price_two->max = 3000000;
        $price_two->name = '500000-3000000';
        $price_range [] = $price_two;
        $price_three = new \stdClass();
        $price_three->id = 2;
        $price_three->min = 3000000;
        $price_three->max = null;
        $price_three->name = 'Above 3000000 MMK';
        $price_range [] = $price_three;
        return $price_range;
    }

    public function getFilteredSubProducts($request)
    {
        $things['product'] = Product::class;
        $things['style'] = Style::class;
        $things['collection'] = Collection::class;
        $brand_ids = ($request->brand_ids) ? JsonDecode($request->brand_ids) : null;
        $color_ids = ($request->color_ids) ? JsonDecode($request->color_ids) : null;
        $gender_id = ($request->gender_id) ?: null;
        $thing = $things[$request->type];
        $kind_query = $thing::when($brand_ids, function ($query) use ($brand_ids) {
            return $query
                ->WhereHas('thing.brands', function ($query) use ($brand_ids) {
                    $query->whereIn('id', $brand_ids);
                });
        })
            ->when($color_ids, function ($query) use ($color_ids) {
                return $query->WhereHas('thing.colors', function ($query) use ($color_ids) {
                    $query->whereIn('id', $color_ids);
                });
            })
            ->when($gender_id, function ($query) use ($gender_id) {
                return $query->WhereHas('thing.genders', function ($query) use ($gender_id) {
                    $query->where('id', $gender_id);
                });
            });

        if ($request->type == 'product') {
            $price_range_ids = ($request->price_range_ids) ? JsonDecode($request->price_range_ids) : null;
            $sub_category_id = $request->sub_category_id;
            if ($price_range_ids) {
                $price_range_id = $price_range_ids[0];
                    $price = $this->setPriceRange()[$price_range_id];
                    $kind_query->when($price, function ($query) use ($price) {
                        return $query->WhereHas('sub_products.product_prices', function ($query) use ($price) {
                            $query->whereBetween('id', [$price->min, $price->max]);
                        });
                    });
                
            }
            $size_ids = ($request->size_ids) ? JsonDecode($request->size_ids) : null;
            $sub_variation_ids = ($request->sub_variation_ids) ? JsonDecode($request->sub_variation_ids) : null;
            $kind_query
                ->when($sub_variation_ids, function ($query) use ($sub_variation_ids) {
                    return $query->WhereHas('thing.sub_variations', function ($query) use ($sub_variation_ids) {
                        $query->whereIn('id', $sub_variation_ids);
                    });
                })
                ->when($size_ids, function ($query) use ($size_ids) {
                    return $query->WhereHas('thing.sizes', function ($query) use ($size_ids) {
                        $query->whereIn('id', $size_ids);
                    });
                })
                ->when($sub_category_id, function ($query) use ($sub_category_id) {
                    return $query->WhereHas('thing.sub_categories', function ($query) use ($sub_category_id) {
                        $query->where('id', $sub_category_id);
                    });
                });
        }
        
        $kind_things = $kind_query->select('id')->paginate(20);
        if ($request->type == 'product') {
            foreach ($kind_things as $product) {
                (new ProductListing())->card($product);
            }
        }
        
        if ($request->type == 'style') {
            foreach ($kind_things as $style) {
                (new StyleListing())->card($style);
            }
        }

        if ($request->type == 'collection') {
            foreach ($kind_things as $collection) {
                $collection->name_translations = $collection->name_translations;
                $collection->description_translations = $collection->description_translations;
                $collection->feature_photo = $collection->collection_photo->name;
                UnsetData($collection, ['thing', 'collection_photo']);
            }
        }
        $cards = $kind_things;
        responseData('data', $cards, 200);
    }

    public function getVariationsByCategoryId($request)
    {
        $category_id = $request->category_id;
        $variations = new \stdClass();
        $sub_category_ids = SubCategory::where('category_id',$category_id)->pluck('id');
        $type_ids = $this->getThingIdsByType($sub_category_ids,'Product');
        $occasion_ids = $this->getKindsByProducts($type_ids, 'occasion');
        $color_ids = $this->getKindsByProducts($type_ids, 'color');
        $season_ids = $this->getKindsByProducts($type_ids, 'season');
        $variations->sub_categories =   (new SubCategories())->getSubCategoriesByCategory($category_id);
        $variations->occasions = Occasion::whereIn('id', $occasion_ids)->select('id')->get();
        $variations->colors = Color::whereIn('id', $color_ids)->select('id', 'color_code')->get();
        $variations->seasons = Season::whereIn('id', $season_ids)->select('id', 'name')->get();
        responseData('variations_by_category_id', $variations, 200);
    }
}

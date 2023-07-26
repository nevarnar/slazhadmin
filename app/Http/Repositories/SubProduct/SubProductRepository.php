<?php

namespace App\Http\Repositories\SubProduct;

use App\Models\Color;
use App\Models\SubProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Actions\Inventory\Common;
use App\Http\Actions\NameTranslation\NameSearching;

class SubProductRepository implements SubProductRepositoryInterface
{
    private $select_data = ['id', 'sku', 'is_available', 'product_id', 'size_id', 'color_id'];
    private $select = ['id', 'product_id', 'sku'];
    function list($request) {
        $routeName = Route::currentRouteName();
        // if(Auth::guard('web')->check()){
        //     $sub_products= SubProduct::with('product','color','size','product_prices')->select($this->select_data)->orderBy('created_at', 'desc')
        //     ->get();
        // }
        if ($routeName !== 'get_sub_products') {
            $sub_products = $this->querySubProduct()->with('product', 'product_prices')->get();
        } else {
            $sub_products = $this->querySubProduct()->with('product', 'color', 'size', 'product_prices');
            // ->isAvailable(1);

            if ($request->search_input != null || $request->search_input != "") {
                (new NameSearching())->searchName($sub_products, $request->search_input);
            }
            $sub_products = $sub_products->get();
            foreach ($sub_products as $sub_product) {
                (new Common())->setSubProductPhoto($sub_product);

            }
        }
        return $sub_products;
    }

    public function getAvailableColorByProduct($product_id)
    {
        $available_colors = SubProduct::where(function ($query) use ($product_id) {
            $query->whereProductId($product_id)
                ->whereIsAvailable(true);
        })->orderBy('color_id', 'desc')->get();
        // return $available_colors;
        foreach ($available_colors as $available_color) {
            $colors[] = $available_color->color;
        }
        $available_unique_colors=collect(array_values(array_unique($colors)));
        return $available_unique_colors->values();

    //     $product_colors_in_style=DB::table('product_style')
    //     ->selectRaw('colors.id')
    //     ->where('product_id',$product_id)
    //     ->join('colors','colors.id','product_style.color_id')
    //     ->get();

    //    $color_id_array=[];
    //     $product_unique_color_in_style=($product_colors_in_style)->unique();
    //     foreach($product_unique_color_in_style as $p){
    //         array_push($color_id_array,$p->id);
    //     }
    //     $available_unique_colors=collect(array_values(array_unique($colors)));
    //      $filter_colors= $available_unique_colors->whereNotIn('id',$color_id_array);
    //     return $filter_colors->values();
    }

    protected function querySubProduct()
    {
        return SubProduct::with(['product', 'product.thing.sub_categories', 'product.thing.series', 'product.thing.brands'])
            ->select($this->select_data)
            ->productIsAvailable()
            ->orderBy('created_at', 'desc');
        // ->isAvailable(1);
    }

    public function searchSubProduct($request)
    {
            return $this->querySubProduct()->whereIsAvailable(1)
                ->search($request)->get();
    }

}

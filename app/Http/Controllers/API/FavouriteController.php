<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Product\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\SubProduct;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $repo)
    {
        $this->productRepository = $repo;
    }

    public function setFavourite(Request $request)
    {
        $user = UserData();
        $type = Model($request->type);
        $object = $type::find($request->id);
        if($object){
            ($request->is_already_favourite) ?
                $object->favouriteUser()->detach($user) :
                $object->favouriteUser()->attach($user);
            responseTrue('success');
        }
        responseTrue('object is not found');
}

public
function getFavorite(Request $request)
{
    $user = UserData();
    $products = $user->favouriteProducts;
    $products = $this->productRepository->setProductData($products);
    responseData('favorite_products', $products, 200);
}
}

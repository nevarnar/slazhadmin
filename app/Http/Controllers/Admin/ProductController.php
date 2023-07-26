<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Repositories\Product\ProductRepositoryInterface;
use App\Http\Requests\API\Product\ProductCreateOrUpdateRequest;

class ProductController extends Controller
{
    //
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $repo)
    {
        $this->productRepository=$repo;
    }
    public function getAllProducts(Request $request){
        $products=$this->productRepository->list($request);
        (new ResponsePaginatedApiData($products, $request));
    }

    public function getProducts(){
        $products = $this->productRepository->listWhenIsAvailableTrue();
        responseData('data',$products,200);
    }

    public function getProduct(Product $product){
        $product=$this->productRepository->details($product);
        responseData('data',$product,200);
    }
    // only product request validation
    public function validateProductRequest(ProductCreateOrUpdateRequest $request){
        return responseStatus('success',200);
    }
    // end
    public function createOrUpdate(Request $request){
        (new UniqueCheck())->run($request,'product');
        $product=$this->productRepository->createOrUpdate($request);
        responseData('data', $product, 200);
    }

    public function changeProductIsAvailable(Request $request){
        $product= Product::find($request->id);
        // dd($product->styles);
        if ($product) {
            $product->is_available = $request->is_available;
            $product->save();
                foreach($product->styles as $s){
                    if($request->is_available==0){
                        $s->is_available=$request->is_available;
                    }else{
                        $check_unavailable_product=$s->products->contains('is_available',0);
                        if($check_unavailable_product){
                            $s->is_available=0;
                        }else{
                            $s->is_available=1;
                        }
                    }
                    // dd($s->is_available);
                    $s->save();
                }
            // }
            responseStatus('Available update successfully', 200);
        }
        responseStatus("Available can't update for this product,Pls try again", 403);
    }
    public function getSubProductByProduct(Product $product){
        $product= $this->productRepository->getSubProductByProduct($product);
        return responseData('sub_products', $product->sub_products, 200);
    }
    public function getAvailableSizeByProductAndColor($product_id,$color_id){
        $products= $this->productRepository->availableSizeByProductAndColor($product_id,$color_id);
        return responseData('products', $products, 200);
    }

    public function getProductBySubCategory(Request $request,$sub_product_id){
        $products= $this->productRepository->getProductBySubCategory($sub_product_id);
        (new ResponsePaginatedApiData($products, $request));
    }

    public function getPromotionCategory(Request $request){
        $products= $this->productRepository->getProductBySeriesAndBrand($request);
        return responseData('data', $products, 200);
    }

    public function deletePhoto(Request $request){
        $this->productRepository->deletePhoto($request);
        return responseStatus('Delete Successfully ',200);
    }

    public function checkBuyingProduct(Request $request){
        $product=Product::find($request->product_id);
        if($product){
            foreach($product->sub_products as $sub){
                $sub_id[]=$sub->id;
            }
            if(!empty($sub)){
                $order_item=OrderItem::whereHas('order',function($q)use($request){
                    $q->where('status','confirmed')
                    ->where('user_id',$request->user_id);
                })
                ->where('orderable_type','sub_product')
                ->whereIn('orderable_id',$sub_id)

                ->first();
                if($order_item){
                    responseStatus('This product have been bought by user',402);
                }
                return $order_item;
            }
        }
        responseStatus("Product isn't found",404);


    }
}


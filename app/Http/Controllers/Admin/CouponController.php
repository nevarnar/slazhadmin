<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Coupon\CouponInterface;
use App\Http\Repositories\Brand\BrandRepositoryInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Repositories\Series\SeriesRepositoryInterface;
use App\Http\Repositories\Product\ProductRepositoryInterface;
use App\Http\Repositories\Collection\CollectionRepositoryInterface;
use App\Http\Repositories\Style\StyleRepository;
use App\Http\Repositories\SubCategory\SubCategoryRepositoryInterface;
use App\Http\Requests\API\Coupon\CouponCreateRequest;

class CouponController extends Controller
{
    //
    private $couponRepository,$brandRepository,$productRepository,$subcategoryRepository,$seriesRepository,$collectionRepository,$styleRepository;
    public function __construct(CouponInterface $repo,BrandRepositoryInterface $brand_repo,ProductRepositoryInterface $product_repo,SubCategoryRepositoryInterface $subcategory_repo,SeriesRepositoryInterface $series_repo,
    
    CollectionRepositoryInterface $collection_repo,StyleRepository $style_repo){
        $this->couponRepository=$repo;
        $this->brandRepository=$brand_repo;
        $this->productRepository=$product_repo;
        $this->subcategoryRepository=$subcategory_repo;
        $this->seriesRepository=$series_repo;
        $this->collectionRepository=$collection_repo;
        $this->styleRepository=$style_repo;
    }

    public function index(Request $request){
        $coupons=$this->couponRepository->list($request);
        (new ResponsePaginatedApiData($coupons, $request));
    }

    public function createOrUpdate(CouponCreateRequest $request){
        $coupons=$this->couponRepository->createOrUpdate($request);
        responseData('data', $coupons, 200);
    }
    public function show(Coupon $coupon){
        $coupons=$this->couponRepository->detail($coupon);
        responseData('data', $coupons, 200);
    }
    public function getCouponFeature(Request $request){
        switch ($request->type) {
            case 'product':
                $data= $this->productRepository->listWhenIsAvailableTrue();
                break;
            case 'collection':
                $data= $this->collectionRepository->list($request);
                break;
            case 'brand':
                $data= $this->brandRepository->availableList($request);
                break;
            case 'series':
                $data= $this->seriesRepository->getProductSeries($request);
                break;
            case 'sub_category':
                $data= $this->subcategoryRepository->list($request);
                break;
            case 'style_name':
                    $data= $this->styleRepository->styleNameList($request);
                break;
        }
        // $deliveries = $this->couponRepository->getCouponFeature($request);
        responseData('data', $data, 200);
    }

    public function destroy(Coupon $coupon){
        ($this->couponRepository->delete($coupon)) ?
         responseTrue('Coupon Delete Successfully ') : responseFalse();
    }
    
    public function getCouponType(Request $request){
        $coupon_type=$this->couponRepository->getCouponType($request);
        responseData('data', $coupon_type, 200);
    }

    public function getCouponDiscountType(Request $request){
        $coupon_discount_type=$this->couponRepository->getCouponDiscountType($request);
        responseData('data', $coupon_discount_type, 200);

    }
    
}

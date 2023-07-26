<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ads;
use App\Models\AdsType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Ads\AdsRepository;
use App\Http\Requests\API\AdsCreateUpdateRequest;
use App\Http\Repositories\Tag\TagRepositoryInterface;
use App\Http\Repositories\Style\StyleRepositoryInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Repositories\Series\SeriesRepositoryInterface;
use App\Http\Repositories\Product\ProductRepositoryInterface;
use App\Http\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Repositories\Collection\CollectionRepositoryInterface;

class AdsController extends Controller
{
    //

    private $adsRepository;
    private $collectionRepository;
    private $categoryRepository;
    private $tagRepository;
    private $productRepository;
    private $styleRepository;
    private $seriesRepository;

    public function __construct(AdsRepository $repo,CollectionRepositoryInterface $collection_repo,CategoryRepositoryInterface $category_repo,TagRepositoryInterface $tag_repo,ProductRepositoryInterface $product_repo,StyleRepositoryInterface $style_repo,SeriesRepositoryInterface $series_repo)
    {
        $this->adsRepository=$repo;
        $this->collectionRepository=$collection_repo;
        $this->categoryRepository=$category_repo;
        $this->tagRepository=$tag_repo;
        $this->styleRepository=$style_repo;
        $this->productRepository=$product_repo;
        $this->seriesRepository=$series_repo;
    }

    public function index(Request $request){
        $ads=$this->adsRepository->list($request);
        (new ResponsePaginatedApiData($ads, $request));
    }

    public function createOrUpdate(AdsCreateUpdateRequest $request){
        $ads = $this->adsRepository->createOrUpdate($request);
        responseData('data', $ads, 200);
    }
    public function show($ads_id,Request $request){
        $ads = $this->adsRepository->getDetails($ads_id);
        if($ads->adsable_type!='url'){
            $request->type=$ads->adsable_type;
            $ads->ads_type_data=$this->getAdsItem($request);
        }
        responseData('data', $ads, 200);
    }

    public function createAdsType(Request $request){
        AdsType::create([
            'name'=>$request->name,
        ]);
        responseTrue('Ads Type created successfully');
    }

    public function getAdsType(){
        $ads_type=$this->adsRepository->getAdsType();
        responseData('data',$ads_type,200);
    }

    public function getAdsTypeList(Request $request){
        $ads_type=$this->adsRepository->getAdsType();
        (new ResponsePaginatedApiData($ads_type, $request));
    }

    public function editAdsType($ads_type){
        $ads_type=AdsType::find($ads_type);
        responseData('data', $ads_type, 200);
    }

    public function createOrUpdateAdsType(Request $request){
        $data = $request->all();
        DB::beginTransaction();
        try {
            if (!isset($request->id)) {
                $data['id'] = null;
            }
            $ads = AdsType::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        responseData('data', $ads, 200);
    }

    public function destroy($ads_id){
        ($this->adsRepository->delete($ads_id))? responseTrue('Deleted successfully '):responseFalse();
    }


    public function getAdsTypeData(Request $request){
       $ads_type_data= $this->getAdsItem($request);
        // switch ($request->type) {
        //     case "collection":
        //         $ads_type_data=$this->collectionRepository->list($request);
        //         break;
        //         #for only style category
        //     case "category":
        //         $ads_type_data=$this->categoryRepository->listWithType($request,'style');
        //         break;
        //     case "tag":
        //             $ads_type_data=$this->tagRepository->list($request);
        //             break;
        // }
        responseData('data',$ads_type_data,200);
    }

    public function getAdsItem($request){
        switch ($request->type) {
            case "collection":
                return $this->collectionRepository->list($request);
                break;
                #for only style category
            case "category":
               return $this->categoryRepository->listWithType($request,'style');
                break;
            case "tag":
                return $this->tagRepository->list($request);
                break;
            case "style" :
                return $this->styleRepository->availableList($request);
                break;
            case "product" : 
                return $this->productRepository->list($request);
                break;
            case "series" : 
                return $this->seriesRepository->listWithType($request,'product');
                break;
        }
        // return $ads_type_data;
    }
}

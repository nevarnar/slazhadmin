<?php

namespace App\Http\Controllers\API;

use App\Http\Actions\Product\CollectionsOfATag;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Collection\CollectionRepositoryInterface;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    private $collectionRepo;

    public function __construct(CollectionRepositoryInterface $repo)
    {
        $this->collectionRepo=$repo;
    }

    public function getCollectionListByGender(Request $request){
            $collections =  $this->collectionRepo->getListByGender($request);
            $paginated_collections = paginate($collections,$request);
            responseData('collections',$paginated_collections,200);
    }

    public function collectionDetail(Request $request){
        $collection =  $this->collectionRepo->collectionDetail($request->collection_id,$request);
        responseData('collection',$collection,200);
    }

    public function getStylesByCollection(Request $request){
        $styles_collection = $this->collectionRepo->getStylesByCollection($request->collection_id,$request);
        responseData('styles_collection',$styles_collection,200);
    }

    public function getProductsByCollection(Request $request){
        $products_collection = $this->collectionRepo->getProductsByCollection($request->collection_id,$request);
        responseData('products_collection',$products_collection,200);
    }

    public function getCollectionByTagName(Request $request){
        $tag_collections =  (new CollectionsOfATag())->run('style-collection',$request->gender_id);
        responseData('tag_collection',$tag_collections,200);
    }

}

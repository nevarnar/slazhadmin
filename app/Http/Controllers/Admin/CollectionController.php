<?php

namespace App\Http\Controllers\Admin;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Repositories\Collection\CollectionRepositoryInterface;

class CollectionController extends Controller
{
    //
    private $collectionRepo;

    public function __construct(CollectionRepositoryInterface $repo)
    {
        $this->collectionRepo=$repo;
    }
    public function index(Request $request){
        $collections=$this->collectionRepo->list($request);
        (new ResponsePaginatedApiData($collections, $request));
    }
    public function getCollections(Request $request){
        $collections=$this->collectionRepo->list($request);
        responseData('data',$collections,200);
    }
    public function createOrUpdate(Request $request){
        $collections=$this->collectionRepo->createOrUpdate($request);
        responseData('data',$collections,200);
    }
    public function show(Collection $collection){
        $collections=$this->collectionRepo->details($collection);
        responseData('data',$collections,200);
    }
    public function destroy(Collection $collection){
        DB::transaction(function () use ($collection) {
            $collection->delete();
            $this->collectionRepo->destroy($collection);
        });
       
       
        responseStatus('Collection deleted successfully',200);
    }
}

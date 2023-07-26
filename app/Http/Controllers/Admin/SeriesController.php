<?php

namespace App\Http\Controllers\Admin;

use App\Models\Series;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Repositories\Series\SeriesRepositoryInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

class SeriesController extends Controller
{
    //
    private $seriesRepository;

    public function __construct(SeriesRepositoryInterface $repo)
    {
        $this->seriesRepository=$repo;
    }

    public function index(Request $request){
        $series=$this->seriesRepository->list($request);
        (new ResponsePaginatedApiData($series, $request));
    }
    public function getSeriesWithType(Request $request,$type){
        $series=$this->seriesRepository->listWithType($request,$type);
        responseData('data', $series, 200);
    }

    public function getProductSeries(Request $request){
        $series=$this->seriesRepository->getProductSeries($request);
        responseData('data', $series, 200);

    }

    public function createOrUpdate(Request $request){
        (new UniqueCheck())->run($request,'series');
        $series = $this->seriesRepository->createOrUpdate($request);
        responseData('data', $series, 200);
    }
    
    public function show(Series $series){
        $series = $this->seriesRepository->details($series);
        responseData('data', $series, 200);
    }
    
}

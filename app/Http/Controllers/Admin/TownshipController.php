<?php

namespace App\Http\Controllers\Admin;

use App\Models\Township;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Township\TownshipInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

class TownshipController extends Controller
{
    //
    private $townshipRepository;

    public function __construct(TownshipInterface $repo)
    {
        $this->townshipRepository=$repo;
    }

    public function test_json(){
        $townships = json_decode(file_get_contents(storage_path() . "/Setup/township.json"), true);
        foreach($townships as $township){
            dd($township);
            dd($township['township']['mm_name']);
            dd($township['eng']['name']);
        }
        echo "<pre>";
        print_r($townships);

    }

    public function index(Request $request){
        $township=$this->townshipRepository->list($request);
        (new ResponsePaginatedApiData($township, $request));
    }

    public function getTownships(Request $request){
        $township=$this->townshipRepository->getTownships($request);
        responseData('data',$township,200);
    }
    public function getDivisions(Request $request){
        $divisions=$this->townshipRepository->getDivisions($request);
        responseData('data',$divisions,200);
    }
    public function getTownshipByDivision($division_id){
        $divisions=$this->townshipRepository->getTownshipByDivision($division_id);
        responseData('data',$divisions,200);
    }

    public function show(Township $township){
        $township_item=$this->townshipRepository->details($township);
        responseData('data',$township_item,200);
    }

    public function createOrUpdate(Request $request){
        $created_township=$this->townshipRepository->createOrUpdate($request);
        responseData('data',$created_township,200);
    }

    public function update(Request $request){
        $updated_township=$this->townshipRepository->update($request);
        responseData('data',$updated_township,200);
    }

    public function destroy(Township $township){
        ($this->townshipRepository->delete($township)) ?
         responseTrue('Township Delete Successfully ') : responseFalse();
    }
}

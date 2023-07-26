<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\SearchRequest;
use App\Http\Actions\NameTranslation\NameSearching;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Services\ModelRepositoryMappingService\ModelRepositoryMappingServiceInterface;

class SearchController extends Controller
{
    //
    private ModelRepositoryMappingServiceInterface $modelRepoMapper;

    public function __construct(ModelRepositoryMappingServiceInterface $modelRepoMapper)
    {
        $this->modelRepoMapper = $modelRepoMapper;
    }

    public function search(SearchRequest $request)
    {
        $repo = $this->modelRepoMapper->getRepository($request->type);
        $repo = new $repo();
        $search_results = (new NameSearching())->search($request->search_input,$request->type,$request->search_collection);
        $data = collect();
        foreach($search_results as $search_result){
            $data->push($repo->details($search_result));
        }

        (new ResponsePaginatedApiData($data, $request));
        // responseData('data', $data, 200);
    }
}

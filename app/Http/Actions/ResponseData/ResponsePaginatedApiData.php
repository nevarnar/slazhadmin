<?php

namespace App\Http\Actions\ResponseData;

use Illuminate\Http\Request;
use App\Http\Actions\Paginate\paginate;

class ResponsePaginatedApiData
{
    private paginate $paginator;
    
    public function __construct($data, Request $request)
    {
        $this->paginator = new paginate($data, $request);
        responseData('data', $this->paginator->run(), 200);
    }
}

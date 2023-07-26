<?php

namespace App\Http\Repositories\SaleReturn;

interface SaleReturnInterface
{

    public function list($request);

    public function updateSaleReturnAction($request);
    

}
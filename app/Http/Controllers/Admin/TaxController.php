<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Tax\TaxRepositoryInterface;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    private $taxRepository;

    public function __construct(TaxRepositoryInterface $repo){
        $this->taxRepository=$repo;
    }

    public function getTaxes(){
        $taxes=$this->taxRepository->list();
        responseData('data',$taxes,200);
    }
}
 
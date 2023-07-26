<?php

namespace App\Http\Repositories\Tax;
use App\Models\Tax;
use App\Http\Repositories\Tax\TaxRepositoryInterface;

 class TaxRepository implements TaxRepositoryInterface{

    private $select_data=['id','country','amount'];
     public function list(){
         return Tax::select($this->select_data)->get();
     }
 }
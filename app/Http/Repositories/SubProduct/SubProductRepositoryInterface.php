<?php 

namespace App\Http\Repositories\SubProduct;

interface SubProductRepositoryInterface 
{
  public function list($request);


  public function getAvailableColorByProduct($id);

  public function searchSubProduct($request);
}
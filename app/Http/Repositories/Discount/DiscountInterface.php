<?php

namespace App\Http\Repositories\Discount;

interface DiscountInterface
{

    public function list($request);

    public function createOrUpdate($request);

    public function details($discount);

    public function delete($discount);

    public function getDiscountType();

    public function validateDiscountSubProduct($request);

    public function getDiscountByProduct($product_id);

    public function getFlashSaleItems($gender_id);

    public function getFlashSaleStyles($gender_id);
    #new discount

}

<?php

namespace App\Http\Repositories\FlashSale;

interface FlashSaleInterface
{
    public function list($request);

    public function createOrUpdate($request);

    public function details($flash_sale);

    public function delete($flash_sale);

    public function deleteItem($request);

    public function validateSubProductForFlashSale($request);
}

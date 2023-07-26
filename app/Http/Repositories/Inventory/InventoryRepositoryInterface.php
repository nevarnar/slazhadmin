<?php

namespace App\Http\Repositories\Inventory;

use App\Models\Shelf;
use App\Models\Inventory;

interface InventoryRepositoryInterface
{

    public function list($request);
    
    public function createOrUpdate($request);

    public function delete(Inventory $inv);

    public function details(Inventory $inv);

    public function deleteShelf(Shelf $shelf);
}

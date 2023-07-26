<?php

namespace App\Http\Repositories\Floor;

interface FloorRepositoryInterface
{
    public function floorByInventory($inventory_id);
}

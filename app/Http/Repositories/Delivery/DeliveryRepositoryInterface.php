<?php

namespace App\Http\Repositories\Delivery;

use App\Models\DeliveryMan;

interface DeliveryRepositoryInterface
{
    public function list($request);
    
    public function createOrUpdate($request);

    public function delete($delivery_id);

    public function details(DeliveryMan $dm);

    public function getDetails($delivery_id);

    public function getDelivery();
    
}

<?php

namespace App\Http\Repositories\Order;

interface OrderInterface
{
    public function list($request);

    public function createOrUpdate($request);

    public function orderListByInventory($request);

    public function actionStatus($request);

    public function deleteOrderItem($order_item_id);

    public function saveDeliveryMan($request);

    public function actionStatusInventoryOrder($request);
}

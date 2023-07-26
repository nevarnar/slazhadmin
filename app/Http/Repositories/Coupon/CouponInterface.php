<?php

namespace App\Http\Repositories\Coupon;


interface CouponInterface {

    public function list($request);

    public function getCouponType($request);

    public function getCouponDiscountType($request);

    public function createOrUpdate($request);

    public function detail($coupon);

    public function delete($coupon);


}
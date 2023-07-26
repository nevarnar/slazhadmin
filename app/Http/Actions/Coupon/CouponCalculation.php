<?php

namespace App\Http\Actions\Coupon;

use App\Models\OrderItem;
use stdClass;

class CouponCalculation
{
    public function setCouponForm($coupon)
    {
        $min_list = new stdClass();
        $limitation_list = new stdClass();
        // $collection=$style=$sub_category=$series=$brand=$product=[];
        // $limitation_collection=$limitation_style=$limitation_sub_category=$limitation_series=$limitation_brand=$limitation_product=[];
        if ($coupon->min_buying_condition->isNotEmpty()) {
            foreach ($coupon->min_buying_condition as $min) {
                $min->buyable_type == 'brand' ?
                $min_list->brand = $min->buyable_id : $min_list->brand = null;
                $min->buyable_type == 'sub_category' ?
                $min_list->sub_category = $min->buyable_id : $min_list->sub_category = null;
                $min->buyable_type == 'product' ?
                $min_list->product = $min->buyable_id : $min_list->product = null;
                $min->buyable_type == 'series' ?
                $min_list->series = $min->buyable_id : $min_list->series = null;
                $min->buyable_type == 'collection' ?
                $min_list->collection = $min->buyable_id : $min_list->collection = null;
                $min->buyable_type == 'style_name' ?
                $min_list->stylist = $min->buyable_id : $min_list->stylist = null;
                // if($min->buyable_type=='brand'){
                //     array_push($brand,$min->buyable_id);
                // }
                // if($min->buyable_type=='product'){
                //     array_push($product,$min->buyable_id);

                // }
                // if($min->buyable_type=='series'){
                //     array_push($series,$min->buyable_id);

                // }
                // if($min->buyable_type=='collection'){
                //     array_push($collection,$min->buyable_id);
                // }
                // if($min->buyable_type=='sub_category'){
                //     array_push($sub_category,$min->buyable_id);
                // }
                // if($min->buyable_type=='style'){
                //     array_push($style,$min->buyable_id);
                // }
            }
            // $min_list->brand=$brand;
            // $min_list->product=$product;
            // $min_list->series=$series;
            // $min_list->collection=$collection;
            // $min_list->sub_category=$sub_category;
            // $min_list->style=$style;
        } else {
            $min_list = null;
        }

        if ($coupon->coupon_limitation->isNotEmpty()) {
            foreach ($coupon->coupon_limitation as $limit) {
                $limit->limitable_type == 'brand' ? $limitation_list->brand = $limit->limitable_id : $limitation_list->brand = null;
                $limit->limitable_type == 'product' ? $limitation_list->product = $limit->limitable_id : $limitation_list->product = null;
                $limit->limitable_type == 'sub_category' ? $limitation_list->sub_category = $limit->limitable_id : $limitation_list->sub_category = null;
                $limit->limitable_type == 'series' ? $limitation_list = $limit->limitable_id : $limitation_list->series = null;
                $limit->limitable_type == 'collection' ? $limitation_list->collection = $limit->limitable_id : $limitation_list->collection = null;
                $limit->limitable_type == 'style_name' ? $limitation_list->stylist = $limit->limitable_id : $limitation_list->stylist = null;
                // if($limit->limitable_type=='brand'){
                //     array_push($limitation_brand,$limit->limitable_id);
                // }
                // if($limit->limitable_type=='product'){
                //     // array_push($limitation_product,$limit->limitable_id);
                // }
                // if($limit->limitable_type=='series'){
                //     array_push($limitation_series,$limit->limitable_id);

                // }
                // if($limit->limitable_type=='collection'){
                //     array_push($limitation_collection,$limit->limitable_id);
                // }
                // if($limit->limitable_type=='sub_category'){
                //     array_push($limitation_sub_category,$limit->limitable_id);
                // }
                // if($limit->limitable_type=='style'){
                //     array_push($limitation_style,$limit->limitable_id);
                //     $limitation_list->style=$limit->limitable_id;
                // }
            }
            // $limitation_list->brand=$limitation_brand;
            // $limitation_list->product=$limitation_product;
            // $limitation_list->series=$limitation_series;
            // $limitation_list->collection=$limitation_collection;
            // $limitation_list->sub_category=$limitation_sub_category;
            // $limitation_list->style=$limitation_style;
        } else {
            $limitation_list = null;
        }
        $coupon->min_buying_condition_list = $min_list;

        $coupon->limitation_list = $limitation_list;

        UnsetData($coupon, ['coupon_limitation', 'min_buying_condition']);
        return $coupon;
    }

    public function calTotalOriginalValue($items)
    {
        $total_value = 0;
        foreach ($items as $i) {
            $order_item = OrderItem::find($i['id']);
            $total_value += $order_item->original_price * $i['quantity'];
        }
        return $total_value;
    }
    public function calCouponDiscount($coupon, $order_item, $total_value)
    {
        $type = $order_item->orderable_type;
        $item = $order_item->orderable;
        $thing=$type=='sub_product' ? $item->product->thing : $item->thing;
        #$item is subproduct or style
        $carts = null;
        $coupon = $this->setCouponForm($coupon);
        $min_limitation = $coupon->min_buying_condition_list;
        $item_limitation = $coupon->limitation_list;
        if (($total_value >= $coupon->min_buying_amount) && ($coupon->min_buying_amount != 0)) {
            if ($min_limitation != null) {
                if (!is_null($min_limitation->product) && $type == 'sub_product' && $coupon->min_buying_amount != 0) {
                    if ($this->checkItemLimitation($min_limitation->product, $item->product->id)) {
                        if ($this->cartFilterByLimitation($order_item, $min_limitation, 'product')) {
                            if (!is_null($item_limitation)) {
                                if ($this->cartFilterByLimitation($order_item, $item_limitation, 'product')) {
                                    return true;
                                    // return $this->checkProductItemLimitation($coupon, $item_limitation, $item, $limitation_cart, 'product');
                                }
                            }
                            return true;
                        }
                    }
                }
                if (!is_null($min_limitation->stylist) && ($item->type == 'style') && $coupon->min_buying_amount != 0) {
                    if ($this->checkItemLimitation($min_limitation->stylist, $item->thing->stylists[0]->id)) {
                        if ($this->cartFilterByLimitation($order_item, $min_limitation, 'stylist')) {
                            if (!is_null($item_limitation)) {
                                // $limitation_cart = $this->cartFilterByLimitation($order_item, $min_limitation, 'stylist');
                                if ( $this->cartFilterByLimitation($order_item, $item_limitation, 'stylist')) {
                                    // dd($this->checkProductItemLimitation($coupon,$item_limitation,$item,$limitation_cart,'stylist'));
                                    return true;
                                    // return $this->checkProductItemLimitation($coupon, $item_limitation, $item, $limitation_cart, 'stylist');
                                }
                            }
                            return true;
                        }
                    }
                }
                if (!is_null($min_limitation->brand) && $coupon->min_buying_amount != 0) {
                    if ($this->checkItemLimitation($min_limitation->brand, $thing->brands[0]->id)) {
                        // $cart = $this->cartFilterByLimitation($order_item, $min_limitation, 'brand');
                        if ($this->cartFilterByLimitation($order_item, $min_limitation, 'brand')) {
                            if (!is_null($item_limitation)) {
                                // $limitation_cart = $this->cartFilterByLimitation($order_item, $min_limitation, 'brand');
                                if ($this->cartFilterByLimitation($order_item, $item_limitation, 'brand')) {
                                    return true;
                                    // return $this->checkProductItemLimitation($coupon, $item_limitation, $item, $limitation_cart, 'brand');
                                }
                            }
                            return true;
                        }
                    }
                }
                if (!is_null($min_limitation->series) && $coupon->min_buying_amount != 0) {
                    if ($this->checkItemLimitation($min_limitation->series, $thing->series[0]->id)) {
                        if ($this->cartFilterByLimitation($order_item, $min_limitation, 'series')) {
                            if (!is_null($item_limitation)) {
                                if ($this->cartFilterByLimitation($order_item, $item_limitation, 'series')) {
                                    return true;
                                    // $this->checkProductItemLimitation($coupon, $item_limitation, $item, $limitation_cart, 'series');
                                }
                            }
                            return true;
                        }
                    }
                }
                if (!is_null($min_limitation->sub_category) && $coupon->min_buying_amount != 0) {
                    if ($type == 'sub_product') {
                        if ($this->checkItemLimitation($min_limitation->sub_category, $thing->sub_categories[0]->id)) {
                            if ($this->cartFilterByLimitation($order_item, $min_limitation, 'sub_category')) {
                                if (!is_null($item_limitation)) {
                                    // $limitation_cart = $this->cartFilterByLimitation($order_item, $item_limitation, 'sub_category');
                                    if ($this->cartFilterByLimitation($order_item, $item_limitation, 'sub_category')) {
                                        return true;
                                        // $this->checkProductItemLimitation($coupon, $item_limitation, $item, $limitation_cart, 'sub_category');
                                    }
                                }
                                return true;
                            }
                        }
                    }

                }
            }
        } elseif (!is_null($item_limitation)) {
            $types = ['product', 'stylist', 'brand', 'series', 'sub_category', 'collection'];
            foreach ($types as $type) {
                if (!is_null($item_limitation->$type)) {
                    // $limitation_cart = $this->cartFilterByLimitation($order_item, $item_limitation, $type);
                    if ($this->cartFilterByLimitation($order_item, $item_limitation, $type)) {
                        // dd($this->checkProductItemLimitation($coupon, $item_limitation, $item, $limitation_cart, 'brand'));
                        return true;
                        // return $this->checkProductItemLimitation($coupon, $item_limitation, $item, $limitation_cart, $type);
                    }
                }
            }
        } 
        return false;
        // elseif (is_null($item_limitation) && is_null($min_limitation)) {
        //     return true;
        // }
    }
    protected function checkProductItemLImitation($coupon, $item_limitation, $item, $cart, $limitation_type)
    {
        // $this->checkItemLimitation($item->cart_id,$cart->id);
        if (($cart->id == $item->cart_id)) {
            return true;
            // return $coupon->discount_value;
        }
        return false;

    }

    protected function cartFilterByLimitation($order_item,$min_limitation, $limitation_type)
    {
        $type = $order_item->orderable_type;
        $item = $order_item->orderable;
        // return $carts->filter(function ($cart) use ($min_limitation, $limitation_type) {
            if ($limitation_type == 'product') {
                if($item->product->id==$min_limitation->product){
                    return true;
                }
                // if ($item->cartable_type == 'sub_product') {
                //     return $cart->cartable->product_id == $min_limitation->product;
                // } elseif ($cart->cartable_type == 'product') {
                //     return $cart->cartable_id == $min_limitation->product;
                // }
            }
            if ($limitation_type == 'stylist') {
                if ($type == 'style') {
                    if($item->thing->stylists[0]->id == $min_limitation->stylist){
                        return true;
                    }
                }
            }
            if ($limitation_type == 'brand') {
                if ($type == 'sub_product') {
                    if($item->product->thing->brands[0]->id == $min_limitation->brand){
                        return true;
                    }
                }elseif ($type= 'style') {
                    if ($item->thing->brands->isNotEmpty()) {
                        if($item->thing->brands[0]->id == $min_limitation->brand)
                        return true;
                    }
                }
            }

            if ($limitation_type == 'series') {
                if ($type == 'sub_product') {
                    if($item->product->thing->series[0]->id == $min_limitation->series){
                        return true;
                    }
                }elseif ($type= 'style') {
                    if ($item->thing->brands->isNotEmpty()) {
                        if($item->thing->series[0]->id == $min_limitation->series)
                        return true;
                    }
                }
            }
            if ($limitation_type == 'sub_category') {
                if ($type == 'sub_product') {
                    if($item->product->thing->sub_categories[0]->id == $min_limitation->sub_category){
                        return true;
                    }
                }elseif ($type= 'style') {
                    if ($item->thing->brands->isNotEmpty()) {
                        if($item->thing->sub_categories[0]->id == $min_limitation->sub_category)
                        return true;
                    }
                }
            }
            return false;
    }

    protected function checkItemLimitation($item, $cart_item)
    {
        if ($item == $cart_item) {
            return true;
        }
        return false;
    }

}

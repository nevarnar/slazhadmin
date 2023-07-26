<?php

namespace App\Http\Actions\Listing;

class FlashSale
{
    public function currentFlashSale($type){
        $now_date = now()->format('Y-m-d');
        $now_time = now()->format('h:i:s');
        return \App\Models\FlashSale::whereDate('start_date', '<=', $now_date)
            ->whereDate('end_date', '>=', $now_date)
            ->whereTime('start_time', ' <=', $now_time)
            ->where('is_available', true)
            ->where('flashsaleable_type',$type)
            ->first();
    }

    public function flashSaleData($flash_sale,$current_flash_sale)
    {
        $flash_data = null;
        if($flash_sale && $current_flash_sale){
            $flash_sale->flash_date= $current_flash_sale->only('start_date','end_date','start_time','end_time',
                'min_buying_amount');
            $flash_sale->now =  now()->format('Y-m-d h:i:s');
            $flash_sale->start = $current_flash_sale->start_date. ' '. $current_flash_sale->start_time;
            $flash_sale->end = $current_flash_sale->end_date. ' '.$current_flash_sale->end_time;
            $flash_sale->min_buying_amount = $current_flash_sale->min_buying_amount;
            $flash_data = $flash_sale->only('flash_sale_id','discount_value','quantity','max_buying_count','now',
                'start','end','min_buying_amount');
        }
        return $flash_data;
    }

    public function getFlashSaleSubProducts($gender_id)
    {
        $gender_ids = GetGenderIds($gender_id);
        $flash_sale_sub_products = [];
        $current_flash_sale = $this->currentFlashSale('sub_product');
        if ($current_flash_sale) {
            $f_sub_products = $current_flash_sale->flash_sale_sub_products;
            foreach ($f_sub_products as $f){
               if(in_array($f->sub_product->product->thing->genders[0]->id,$gender_ids)){
                   $flash_sale_sub_products [] = $f;
               }
            }
            if(count($flash_sale_sub_products ) <1 ){
               return  null ;
            }
            $sub_products = [];
            foreach ($flash_sale_sub_products as $flash_sale_sub_product) {
                $sub_product = (new ProductListing())->subCard($flash_sale_sub_product->sub_product);
                $sub_product['discount_value'] = $flash_sale_sub_product->discount_value;
                $sub_product['quantity'] = $flash_sale_sub_product->quantity;
                $sub_product['max_buying_count'] = $flash_sale_sub_product->max_buying_count;
                $sub_products [] = $sub_product;
                UnsetData($flash_sale_sub_product, ['discount_type', 'discountable_type', 'discountable_id', 'discount_type_id', 'sub_product']);
            }
            $this->setFlashDate($current_flash_sale);
            $current_flash_sale->sub_products = $sub_products;
            UnsetData($current_flash_sale, ['flash_sale_sub_products', 'is_available', 'created_at',
                'updated_at', 'flashsaleable_type', 'is_available','start_date','start_time','end_date','end_time']);
            return $current_flash_sale;
        }
        return $current_flash_sale;
    }

    public function getFlashSaleStyles($gender_id){
        $gender_ids = GetGenderIds($gender_id);
        $current_flash_sale = $this->currentFlashSale('style');
        $flash_sale_styles = [];
        if($current_flash_sale){
            $f_styles =  $current_flash_sale->flash_sale_styles;
            foreach ($f_styles as $f){
                if(in_array($f->style->thing->genders[0]->id,$gender_ids)){
                    $flash_sale_styles [] = $f;
                }
            }
            if(count($flash_sale_styles ) <1 ){
                return  null;
            }
            $styles = [];
            foreach($flash_sale_styles as $flash_sale_style){
                $style = (new StyleListing())->card($flash_sale_style->style);
                $style['discount_value'] = $flash_sale_style->discount_value;
                $style['quantity'] = $flash_sale_style->quantity;
                $style['max_buying_count'] = $flash_sale_style->max_buying_count;
                $styles [] = $style;
                UnsetData($flash_sale_style, ['discount_type', 'discountable_type', 'discountable_id', 'discount_type_id', 'style']);
            }
            $this->setFlashDate($current_flash_sale);
            $current_flash_sale->style = $styles;
            UnsetData($current_flash_sale, ['flash_sale_styles', 'is_available', 'created_at',
                'updated_at', 'flashsaleable_type', 'is_available','start_date','start_time','end_date','end_time']);
            return $current_flash_sale;
        }
        return  $current_flash_sale;
    }

    public function setFlashDate($current_flash_sale)
    {
        $current_flash_sale->now = now()->format('Y-m-d h:i:s');
        $current_flash_sale->start = $current_flash_sale->start_date. ' ' .$current_flash_sale->start_time;
        $current_flash_sale->end = $current_flash_sale->end_date. ' '. $current_flash_sale->end_time;
    }
}

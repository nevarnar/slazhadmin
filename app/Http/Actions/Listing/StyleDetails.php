<?php

namespace App\Http\Actions\Listing;

use App\Models\OrderItem;
use App\Models\Style;

class StyleDetails
{
    public function run($style_id)
    {
        $style = $this->getStyle($style_id);
        $this->updateViewCount($style);
        $this->checkUserAction($style);
        $this->stylePriceAndProducts($style);
        $this->getStyleList($style);
        (new StyleDiscount())->run($style);
        $this->getFlashSale($style);
        return UnsetData($style, ['thing', 'products', 'favourite_user', 'flashSale']);
    }

    protected function getStyle($style_id)
    {
        $style = Style::where('id', $style_id)->select('id', 'view_count')
            ->with(['description_translations:id,name,language_code,description_translationable_id',
                'thing.stylists:id', 'style_photos'])->first();
        if ($style == null) responseStatus('Style is not found', 404);
        return $style;
    }

    protected function updateViewCount($style)
    {
        $style->view_count = ++$style->view_count;
        $style->save();
    }

    protected function checkUserAction($style)
    {
        $style->is_already_bought = false;
        $style->is_already_reviewed = false;
        $style->is_already_favourite = false;
        $user = UserData();
        if ($user) {
            $user_id = $user->id;
            $style->is_already_bought = $this->checkUserHaveBoughtStyle($style, $user_id);
            $style->is_already_reviewed = collect($style->reviews)->contains('user_id', $user_id);
            $style->is_already_favourite = $style->favouriteUser->contains($user_id);
        }
    }

    public function checkUserHaveBoughtStyle($style, $user_id)
    {
        $order_item = OrderItem::whereHas('order', function ($q) use ($user_id) {
            $q->where('status', 'confirmed')
                ->where('user_id', $user_id);
        })
            ->where('orderable_type', 'style')
            ->where('orderable_id', $style->id)
            ->first();
        if ($order_item) {
            return true;
        }
        return false;
    }

    public function stylePriceAndProducts($style)
    {
        $style_products = $style->products;
        $style_price = 0;
        $products = [];
        foreach ($style_products as $style_product) {
            $style_price += $style_product->price;
            $style_product = (new ProductsInStyle())->card($style_product);
            $products [] = $style_product;
        }
        $style->price = $style_price;
        $style->style_products = $products;
    }

    protected function getStyleList($style)
    {
        $style->stylist = null;
        if (!empty($style->thing->stylists)) {
            $style->stylist = $style->thing->stylists[0]->name_translations[0]->name;
        }
    }

    protected function getFlashSale($style)
    {
        $flash_sale = collect($style->flashSale)->first();
        $current_flash_sale = (new FlashSale())->currentFlashSale('style');
        $flash_data = (new FlashSale())->flashSaleData($flash_sale, $current_flash_sale);
        $style->style_sale = $flash_data;
    }
}

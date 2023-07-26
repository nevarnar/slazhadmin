<?php

namespace App\Providers;

use App\Models\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Relation::enforceMorphMap([
            'category' => 'App\Models\Category',
            'occasion' => 'App\Models\Occasion',
            'color' => 'App\Models\Color',
            'country' => 'App\Models\Country',
            'brand' => 'App\Models\Brand',
            'supplier' => 'App\Models\Supplier',
            'sub_category' => 'App\Models\SubCategory',
            'variation' => 'App\Models\Variation',
            'sub_variation' => 'App\Models\SubVariation',
            'tag' => 'App\Models\Tag',
            'tax' => 'App\Models\Tax',
            'gender' => 'App\Models\Gender',
            'season' => 'App\Models\Season',
            'product' => 'App\Models\Product',
            'user' => 'App\Models\User',
            'size' => 'App\Models\Size',
            'style'=>'App\Models\Style',
            'collection'=>'App\Models\Collection',
            'ads'=>'App\Models\Ads',
            'delivery_man'=>'App\Models\DeliveryMan',
            'series'=>'App\Models\Series',
            'inventory'=>'App\Models\Inventory',
            'sub_product'=>'App\Models\SubProduct',
            'campaign'=>'App\Models\Campaign',
            'division'=>'App\Models\Division',
            'township'=>'App\Models\Township',
            'admin'=>'App\Models\Admin',
            'style_name'=>'App\Models\StyleName',
            'coupon'=>'App\Models\Coupon',
            'order'=>'App\Models\Order',
            'support_ticket'=>'App\Models\SupportTicket',
            'order_item'=>'App\Models\OrderItem',
            'order_style_product'=>'App\Models\OrderStyleProduct',
            'sale_return'=>'App\Models\SaleReturn',
        ]);
        // View::share('countOfUnread',Notification::countOfUnread()->count());
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Repositories\Ads\AdsRepository;
use App\Http\Repositories\Tag\TagRepository;
use App\Http\Repositories\Tax\TaxRepository;
use App\Http\Repositories\User\UserInterface;
use App\Http\Repositories\Size\SizeRepository;
use App\Http\Repositories\User\UserRepository;
use App\Http\Repositories\Order\OrderInterface;
use App\Http\Repositories\Admin\AdminRepository;
use App\Http\Repositories\Brand\BrandRepository;
use App\Http\Repositories\Color\ColorRepository;
use App\Http\Repositories\Floor\FloorRepository;
use App\Http\Repositories\Order\OrderRepository;
use App\Http\Repositories\Stock\StockRepository;
use App\Http\Repositories\Style\StyleRepository;
use App\Http\Repositories\Coupon\CouponInterface;
use App\Http\Repositories\Filter\FilterInterface;
use App\Http\Repositories\Auth\PhoneAuthInterface;
use App\Http\Repositories\Coupon\CouponRepository;
use App\Http\Repositories\Filter\FilterRepository;
use App\Http\Repositories\Gender\GenderRepository;
use App\Http\Repositories\Review\ReviewRepository;
use App\Http\Repositories\Season\SeasonRepository;
use App\Http\Repositories\Series\SeriesRepository;
use App\Http\Repositories\Address\AddressInterface;
use App\Http\Repositories\Auth\PhoneAuthRepository;
use App\Http\Repositories\Auth\SocialAuthInterface;
use App\Http\Repositories\Address\AddressRepository;
use App\Http\Repositories\Auth\SocialAuthRepository;
use App\Http\Repositories\Country\CountryRepository;
use App\Http\Repositories\Product\ProductRepository;
use App\Http\Repositories\Ads\AdsRepositoryInterface;
use App\Http\Repositories\Tag\TagRepositoryInterface;
use App\Http\Repositories\Tax\TaxRepositoryInterface;
use App\Http\Repositories\Transfer\TransferInterface;
use App\Http\Repositories\Category\CategoryRepository;
use App\Http\Repositories\Delivery\DeliveryRepository;
use App\Http\Repositories\Occasion\OccasionRepository;
use App\Http\Repositories\Supplier\SupplierRepository;
use App\Http\Repositories\Transfer\TransferRepository;
use App\Http\Repositories\FlashSale\FlashSaleInterface;
use App\Http\Repositories\Size\SizeRepositoryInterface;
use App\Http\Repositories\FlashSale\FlashSaleRepository;
use App\Http\Repositories\Inventory\InventoryRepository;
use App\Http\Repositories\Variation\VariationRepository;
use App\Http\Repositories\Admin\AdminRepositoryInterface;
use App\Http\Repositories\Brand\BrandRepositoryInterface;
use App\Http\Repositories\Color\ColorRepositoryInterface;
use App\Http\Repositories\Floor\FloorRepositoryInterface;
use App\Http\Repositories\SaleReturn\SaleReturnInterface;
use App\Http\Repositories\Style\StyleRepositoryInterface;
use App\Http\Repositories\Collection\CollectionRepository;
use App\Http\Repositories\SaleReturn\SaleReturnRepository;
use App\Http\Repositories\SubProduct\SubProductRepository;
use App\Http\Repositories\Defect\DefectRepositoryInterface;
use App\Http\Repositories\Gender\GenderRepositoryInterface;
use App\Http\Repositories\Review\ReviewRepositoryInterface;
use App\Http\Repositories\Season\SeasonRepositoryInterface;
use App\Http\Repositories\Series\SeriesRepositoryInterface;
use App\Http\Repositories\SubCategory\SubCategoryRepository;
use App\Http\Repositories\Country\CountryRepositoryInterface;
use App\Http\Repositories\Notification\NotificationInterface;
use App\Http\Repositories\Product\ProductRepositoryInterface;
use App\Http\Repositories\Notification\NotificationRepository;
use App\Http\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Repositories\Delivery\DeliveryRepositoryInterface;
use App\Http\Repositories\Occasion\OccasionRepositoryInterface;
use App\Http\Repositories\Supplier\SupplierRepositoryInterface;
use App\Http\Repositories\Inventory\InventoryRepositoryInterface;
use App\Http\Repositories\Variation\VariationRepositoryInterface;
use App\Http\Repositories\Collection\CollectionRepositoryInterface;
use App\Http\Repositories\SubProduct\SubProductRepositoryInterface;
use App\Http\Repositories\SubCategory\SubCategoryRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind(UserInterface::class, function (){
//            return new UserRepository();
//        });
        $this->app->bind(UserInterface::class,UserRepository::class);
        $this->app->bind(SocialAuthInterface::class,SocialAuthRepository::class);
        $this->app->bind(PhoneAuthInterface::class,PhoneAuthRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(ColorRepositoryInterface::class, ColorRepository::class);
        $this->app->bind(OccasionRepositoryInterface::class, OccasionRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->bind(SubCategoryRepositoryInterface::class, SubCategoryRepository::class);
        $this->app->bind(VariationRepositoryInterface::class, VariationRepository::class);
        $this->app->bind(GenderRepositoryInterface::class, GenderRepository::class);
        $this->app->bind(SeasonRepositoryInterface::class, SeasonRepository::class);
        $this->app->bind(TaxRepositoryInterface::class, TaxRepository::class);
        $this->app->bind(SizeRepositoryInterface::class, SizeRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(SubProductRepositoryInterface::class, SubProductRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(StyleRepositoryInterface::class, StyleRepository::class);
        $this->app->bind(CollectionRepositoryInterface::class, CollectionRepository::class);
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(AdsRepositoryInterface::class, AdsRepository::class);
        $this->app->bind(DeliveryRepositoryInterface::class, DeliveryRepository::class);
        $this->app->bind(SeriesRepositoryInterface::class, SeriesRepository::class);
        $this->app->bind(InventoryRepositoryInterface::class, InventoryRepository::class);
        $this->app->bind(FloorRepositoryInterface::class, FloorRepository::class);
        $this->app->bind(\App\Http\Repositories\Stock\StockRepositoryInterface::class, \App\Http\Repositories\Stock\StockRepository::class);
        $this->app->bind(DefectRepositoryInterface::class, \App\Http\Repositories\Defect\DefectRepository::class);
        $this->app->bind(\App\Http\Repositories\Invoice\InvoiceInterface::class, \App\Http\Repositories\Invoice\InvoiceRepository::class);
        $this->app->bind(\App\Http\Repositories\Transfer\TransferInterface::class, \App\Http\Repositories\Transfer\TransferRepository::class);
        $this->app->bind(\App\Http\Repositories\Discount\DiscountInterface::class, \App\Http\Repositories\Discount\DiscountRepository::class);
        $this->app->bind(\App\Http\Repositories\Campaign\CampaignInterface::class, \App\Http\Repositories\Campaign\CampaignRepository::class);

        $this->app->bind(\App\Http\Repositories\Division\DivisionInterface::class, \App\Http\Repositories\Division\DivisionRepository::class);

        $this->app->bind(\App\Http\Repositories\Township\TownshipInterface::class, \App\Http\Repositories\Township\TownshipRepository::class);
        $this->app->bind(\App\Http\Repositories\SupportTicket\SupportTicketInterface::class, \App\Http\Repositories\SupportTicket\SupportTicketRepository::class);
        $this->app->bind(\App\Http\Repositories\TicketReply\TicketReplyRepository\TicketReply\TicketReplyRepositoryInterface::class, \App\Http\Repositories\TicketReply\TicketReplyRepository\TicketReply\TicketReplyRepositoryRepository::class);
        $this->app->bind(FilterInterface::class, FilterRepository::class);
        $this->app->bind(AddressInterface::class, AddressRepository::class);
        $this->app->bind(FlashSaleInterface::class, FlashSaleRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
        $this->app->bind(CouponInterface::class, CouponRepository::class);
        $this->app->bind(NotificationInterface::class, NotificationRepository::class);
        $this->app->bind(SaleReturnInterface::class, SaleReturnRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

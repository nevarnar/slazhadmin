<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DeliveryManController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\FlashSaleController;
use App\Http\Controllers\Admin\GenderController;
use App\Http\Controllers\Admin\MeasurementController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OccasionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SaleReturnController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\SizeChartController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SocailiteController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\StyleController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\SubProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SupportTicketController as WebSupportTicketController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\TownshipController;
use App\Http\Controllers\Admin\UnitTypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VariationController;
use App\Http\Controllers\API\ProductController as APIProductController;
use App\Http\Controllers\API\SupportTicketController;
use Illuminate\Support\Facades\Route;

Route::get('users', [UserController::class, 'index'])->name('users');
Route::get('admins', [AdminController::class, 'index'])->name('admins');
Route::get('get_admin', [AdminController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::view('/login', 'layouts.login')->name('login');
Route::get('/edit_stock', [StockController::class, 'editStock']);
Route::post('/save_stock', [StockController::class, 'saveStock']);

Route::group(['middleware' => ['user-access']], function () {
    #product-information-management
    // Route::get('/get_inventories', [App\Http\Controllers\Admin\InventoryController::class, 'getInventory']);
    Route::post('orders/save_delivery_man', [OrderController::class, 'saveDeliveryMan']);
    Route::get('/get_brands', [BrandController::class, 'getBrands']);
    Route::get('/get_sub_categories', [SubCategoryController::class, 'getSubCategories']);
    Route::get('/get_series/{type}', [App\Http\Controllers\Admin\SeriesController::class, 'getSeriesWithType']);
    Route::get('/get_supplier', [SupplierController::class, 'getSuppliers']);
    Route::get('notification_list', [NotificationController::class, 'notificationList'])->name('navbar_notification_list');
    Route::get('/read_notification', [NotificationController::class, 'readNotification']);
    Route::get('/orders', [OrderController::class, 'index']);


    # region setup
    Route::resource('townships', TownshipController::class)->only('index', 'show', 'destroy');
    Route::post('/townships/update', [TownshipController::class, 'update']);

    #ads type
    Route::get('/get_ads_type_list', [App\Http\Controllers\Admin\AdsController::class, 'getAdsTypeList']);
    Route::get('/ads_type_list/{ads_type}', [App\Http\Controllers\Admin\AdsController::class, 'editAdsType']);
    Route::post('/get_ads_type_list/create_or_update', [App\Http\Controllers\Admin\AdsController::class, 'createOrUpdateAdsType']);

    #size
    Route::resource('sizes', SizeController::class)->only('index', 'show');
    Route::post('/sizes/create_or_update', [SizeController::class, 'createOrUpdate']);
    #endsize
    #endregion

    
    Route::post('orders/action_status', [OrderController::class, 'actionStatus']);
    Route::get('/search_sub_products', [App\Http\Controllers\Admin\SubProductController::class, 'searchSubPorductList']); #search with name and sku(item_code) api at collections

  

    Route::group(['middleware' => ['permission-access:product-information-management']], function () {
        Route::view('/categories_lists', 'category.index')->name('categories_lists.index');
        Route::view('/', 'category.index');
        Route::view('/sub_categories_lists', 'sub_category.index')->name('sub_categories_lists.index');
        Route::view('/sub_categories_lists/create', 'sub_category.create');
        Route::view('/sub_categories_lists/edit/{id}', 'sub_category.edit');
        Route::view('/brands_lists', 'brand.index')->name('brands_lists.index');
        Route::view('/colors_lists', 'color.index')->name('colors_lists.index');
        Route::view('/occasions_lists', 'occasions.index')->name('occasions_lists.index');
        Route::view('/variations_lists', 'variations.index')->name('variations_lists.index');
        Route::view('/variations_lists/create', 'variations.create');
        Route::view('/variations_lists/edit/{id}', 'variations.edit');
        Route::view('/suppliers_lists', 'supplier.index')->name('suppliers_lists.index');
        Route::view('/suppliers_lists/create', 'supplier.create');
        Route::view('/suppliers_lists/edit/{id}', 'supplier.edit');
        Route::view('/products_lists', 'product.index')->name('products_lists.index');
        Route::view('/products_lists/create', 'product.create');
        Route::view('/products_lists/edit/{id}', 'product.edit');
        Route::view('/products_lists/sub_product_by_product/{id}', 'product.sub_products');
        Route::view('/sub_products_lists', 'product.sub_products')->name('sub_products_lists.index');
        Route::view('/collection_lists', 'collection.index')->name('collection_lists.index');
        Route::view('/collection_lists/create', 'collection.create');
        Route::view('/collection_lists/edit/{id}', 'collection.edit');

        Route::view('/product_collection', 'product_collection.index');
        Route::view('/product_collection/create', 'product_collection.create');

        Route::view('/ads_lists', 'ads.index')->name('ads_lists');
        Route::view('/ads_lists/create', 'ads.create');
        Route::view('/ads_lists/edit/{id}', 'ads.edit');
        #delivery_fee depend on townships
        Route::view('/townships_list', 'delivery_fees.index');
        Route::view('/ads_type_list', 'ads.ads_type_list');
        Route::view('/size_list', 'size.size_list');

        #category
        Route::get('/categories', [CategoryController::class, 'getAllCategories']);
        Route::get('/get_product_categories/', [CategoryController::class, 'getCategories'])->name('product');
        Route::get('/get_pack_categories', [CategoryController::class, 'getCategories'])->name('pack');
        Route::get('/get_style_categories', [CategoryController::class, 'getCategories'])->name('style');
        Route::get('/get_collection_categories', [CategoryController::class, 'getCategories'])->name('collection');
        Route::get('/categories/{category}', [CategoryController::class, 'getCategory']);
        Route::delete('/categories/{category}', [CategoryController::class, 'deleteCategory']);
        Route::post('/categories/create_or_update', [CategoryController::class, 'createOrUpdate']);
        Route::post('/categories/is_available', [App\Http\Controllers\Admin\CategoryController::class, 'changeCategoryIsAvailable']);

        #occasion
        Route::get('/occasions', [OccasionController::class, 'getAllOccasions']);
        Route::get('/get_occasions', [OccasionController::class, 'getOccasions']);
        Route::get('/occasions/{occasion}', [OccasionController::class, 'getOccasion']);
        Route::delete('/occasions/{occasion}', [OccasionController::class, 'deleteOccasion']);
        Route::post('/occasions/create_or_update', [OccasionController::class, 'createOrUpdate']);
        Route::post('/occasions/is_available', [App\Http\Controllers\Admin\OccasionController::class, 'changeOccasionIsAvailable']);

        #colors
        Route::get('/colors', [ColorController::class, 'getAllColors']);
        Route::get('/get_colors', [ColorController::class, 'getColors']);
        Route::get('/colors/{color}', [ColorController::class, 'getColor']);
        Route::post('/colors/create_or_update', [ColorController::class, 'createOrUpdate']);
        Route::delete('/colors/{color}', [ColorController::class, 'deleteColor']);
        Route::post('/colors/is_available', [App\Http\Controllers\Admin\ColorController::class, 'changeColorIsAvailable']);

        Route::get('/unit_types', [UnitTypeController::class, 'index']);

        #brand
        Route::get('/brands', [BrandController::class, 'getAllBrands']);
        Route::get('/brands/{brand}', [BrandController::class, 'getBrand']);
        Route::post('/brands/create_or_update', [BrandController::class, 'createOrUpdate']);
        Route::delete('/brands/{brand}', [BrandController::class, 'deleteBrand']);
        Route::post('/brands/is_available', [App\Http\Controllers\Admin\BrandController::class, 'changeBrandIsAvailable']);

        #supplier
        Route::get('/suppliers', [SupplierController::class, 'getAllSuppliers']);
        Route::get('/suppliers/{supplier}', [SupplierController::class, 'getSupplier']);
        Route::post('/suppliers/create_or_update', [SupplierController::class, 'createOrUpdate']);
        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'deleteSupplier']);

        #sub_category
        Route::get('/sub_categories', [SubCategoryController::class, 'getAllSubCategories']);
        Route::get('/get_sub_categories_for_variation', [SubCategoryController::class, 'getSubCategories'])->name('sub_category.variation');
        Route::get('/sub_categories/{sub_category}', [SubCategoryController::class, 'getSubCategory']);
        Route::post('/sub_categories/create_or_update', [SubCategoryController::class, 'createOrUpdate']);
        Route::delete('/sub_categories/{sub_category}', [SubCategoryController::class, 'deleteSubCategory']);
        Route::post('/sub_categories/is_available', [App\Http\Controllers\Admin\SubCategoryController::class, 'changeSubCategoryIsAvailable']);

        #variation
        Route::get('/variations', [VariationController::class, 'getAllVariations']);
        Route::post('/variations/create', [VariationController::class, 'createVariation']);
        Route::post('/variations/update/{variation}', [VariationController::class, 'updateVariation']);
        Route::get('/variations/{variation}', [VariationController::class, 'getVariation']);
        Route::delete('/variations/{variation}', [VariationController::class, 'deleteVariation']);
        Route::get('/variations/variation_by_sub_category_id/{sub_category_id}', [VariationController::class, 'getVarationBySubCategory']);
        Route::post('/variations/is_available', [App\Http\Controllers\Admin\VariationController::class, 'changeVariationIsAvailable']);

        Route::get('get_genders', [GenderController::class, 'getGenders']);
        Route::get('get_seasons', [SeasonController::class, 'getSeasons']);
        Route::get('get_taxes', [TaxController::class, 'getTaxes']);

        #size

        Route::get('get_sizes', [SizeController::class, 'getSizes']);

        #end size
        Route::get('/get_tags', [TagController::class, 'getTags']);
        Route::post('/tags/create', [TagController::class, 'create']);

        //* product
        Route::get('/products', [ProductController::class, 'getAllProducts']);
        Route::get('/products_for_style', [ProductController::class, 'getProducts']);
        Route::post('/products/create_or_update', [ProductController::class, 'createOrUpdate']);
        Route::post('/products/validate_product_request', [ProductController::class, 'validateProductRequest']);
        Route::get('/products/{product}', [ProductController::class, 'getProduct']);
        Route::post('/products/is_available', [ProductController::class, 'changeProductIsAvailable']);
        Route::get('/products/sub_product_by_product/{product}', [ProductController::class, 'getSubProductByProduct']);
        Route::get('/products/{product_id}/{color_id}', [ProductController::class, 'getAvailableSizeByProductAndColor']);

        //* sub products
        Route::get('/sub_products', [SubProductController::class, 'getAllSubProducts'])->name('get_sub_products');
        Route::post('/sub_products/is_available', [App\Http\Controllers\Admin\SubProductController::class, 'changeSubProductIsAvailable']);
        // Route::get('/search_sub_products', [App\Http\Controllers\Admin\SubProductController::class, 'searchSubPorductList']); #search with name and sku(item_code) api at collections

        //*Available Color by Product Id
        Route::get('/available_color_by_product/{product_id}', [SubProductController::class, 'getAvailableColorByProduct']);

        //* style
        Route::get('/styles', [StyleController::class, 'getAllStyles']);
        Route::get('/get_styles', [App\Http\Controllers\Admin\StyleController::class, 'getStyles']);
        Route::post('/styles/createOrUpdate', [App\Http\Controllers\Admin\StyleController::class, 'createOrUpdate']);
        Route::get('/styles/{style}', [App\Http\Controllers\Admin\StyleController::class, 'getStyle']);
        Route::post('/styles/is_available', [App\Http\Controllers\Admin\StyleController::class, 'changeStyleIsAvailable']);

        #delete photo for product,style and collection per type
        Route::post('/delete_photo', [App\Http\Controllers\Admin\ProductController::class, 'deletePhoto']);

        //* collection
        Route::resource('collections', App\Http\Controllers\Admin\CollectionController::class)->only('index', 'show', 'destroy');
        Route::post('/collections/createOrUpdate', [App\Http\Controllers\Admin\CollectionController::class, 'createOrUpdate']);
        Route::get('/get_collections', [App\Http\Controllers\Admin\StyleController::class, 'getCollections']);
        Route::post('/collections/is_available', [ProductController::class, 'changeCollectionIsAvailable']);

        #reviews
        Route::get('/get_reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('get_reviews');
        Route::post('reviews/toggleStatus', [App\Http\Controllers\Admin\ReviewController::class, 'actionStatus']);
        Route::delete('/reviews/{review}/delete', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name
            ('delete_review');

        #delivery
        Route::resource('delivery_men', DeliveryManController::class)->only('index', 'show', 'destroy');
        Route::post('/delivery_men/createOrUpdate', [App\Http\Controllers\Admin\DeliveryManController::class, 'createOrUpdate']);
        Route::post('/deliveries/create', [DeliveryManController::class, 'createDelivery']);
        Route::get('/deliveries', [App\Http\Controllers\Admin\DeliveryManController::class, 'getDelivery']);

        #series
        Route::post('/series/createOrUpdate', [App\Http\Controllers\Admin\SeriesController::class, 'createOrUpdate']);
        Route::view('/reviews', 'review.index')->name('reviews');
        Route::view('/style_lists', 'style.index')->name('style_lists.index');
        Route::view('/style_lists/create', 'style.create');
        Route::view('/style_lists/edit/{id}', 'style.edit');
        #measurement
        Route::get('/measurements', [MeasurementController::class, 'index']);
        Route::post('/style_name', [StyleController::class, 'createStyleName']);
        #ads
        Route::get('/ads', [App\Http\Controllers\Admin\AdsController::class, 'index']);
        Route::get('/ads/{id}', [App\Http\Controllers\Admin\AdsController::class, 'show']);
        Route::delete('/ads/{id}', [App\Http\Controllers\Admin\AdsController::class, 'destroy']);
        Route::post('/ads/createOrUpdate', [App\Http\Controllers\Admin\AdsController::class, 'createOrUpdate']);
        Route::post('/ads_type/create', [App\Http\Controllers\Admin\AdsController::class, 'createAdsType']);
        Route::get('/get_ads_type', [App\Http\Controllers\Admin\AdsController::class, 'getAdsType']);

        Route::get('/get_product_series', [App\Http\Controllers\Admin\SeriesController::class, 'getProductSeries']);
        Route::get('get_style_name', [StyleController::class, 'getStyleName']);
        #ads
        Route::get('get_ads_type_data', [AdsController::class, 'getAdsTypeData']);
    });

    Route::group(['middleware' => ['permission-access:inventory-management']], function () {
        Route::view('/warehouse_transfer_list', 'warehouse_transfer.index');
        Route::view('/confirmed_record', 'inventory_confirmed_record.index');
        Route::view('/inventory_report', 'inventory_report.index');
        Route::view('/inventory_report/create', 'inventory_report.create');

        Route::view('/purchase_order', 'purchase_order.index');
        Route::view('/purchase_order/create', 'purchase_order.create');

        Route::view('/inventory_item_search', 'inventory_item_search.index');
        Route::view('/inventory', 'inventory.index');
        Route::view('/inventory_confirmation', 'inventory_confirmation.index');
        Route::view('/inventory_confirmation_detail', 'inventory_confirmation.detail');
        Route::view('/supplier_item', 'supplier_item.index');
        Route::view('/supplier_item_detail', 'supplier_item.detail');
        Route::view('/stocks_lists', 'stock.index')->name('instocks.index');

        Route::view('/stocks/create', 'stock.create');
        Route::view('/defect_confirm_lists', 'defect_list.confirmation')->name('defect.confirm');
        Route::view('/defect_lists', 'defect_list.index')->name('defect.lists');
        Route::resource('defects', App\Http\Controllers\Admin\DefectController::class)->only('index', 'store', 'destroy');
        Route::get('/defects/update_status', [App\Http\Controllers\Admin\DefectController::class, 'updateStatus']);
        Route::get('/defects/confirmation_list', [App\Http\Controllers\Admin\DefectController::class, 'index'])->name('confirmation_list');
        Route::view('/invoice_lists', 'invoice.index')->name('invoice_lists');
        Route::view('/invoice_lists/{id}', 'invoice.detail')->name('invoice_lists.detail');
        Route::get('/inventory_transfer', [App\Http\Controllers\Admin\TransferController::class, 'transferCreateView']);
        Route::view('/inventory_transfer_lists', 'warehouse_transfer.index')->name('inventory_movement.index');
        Route::view('/inventory_transfer_lists/{id}', 'warehouse_transfer.detail')->name('warehouse_transfer.detail');
        Route::view('/inventory_accept_transfer/{id}', 'warehouse_transfer.accept_transfer');
        #inventory
        Route::view('/inventory_lists', 'inventory_list.index')->name('inventory_lists.index');
        Route::view('/inventory_lists/create', 'inventory_list.create');
        Route::view('/inventory_lists/edit/{id}', 'inventory_list.edit');
        #invoice
        Route::resource('invoices', App\Http\Controllers\Admin\InvoiceController::class)->only('index', 'show', 'destroy');

        #stock
        Route::get('/sub_products_by_inventory', [App\Http\Controllers\Admin\StockController::class, 'getStockBySubProduct']);
        Route::get('/sub_product_in_stock', [App\Http\Controllers\Admin\StockController::class, 'getSubProductInStock']);
        Route::get('/discount_sub_product_in_stock', [App\Http\Controllers\Admin\StockController::class, 'getDiscountSubProductInStock']);
        #transfer
        Route::resource('transfers', App\Http\Controllers\Admin\TransferController::class)->only('index', 'show', 'store', 'destroy');
        Route::get('accept_transfer/{transfer}', [App\Http\Controllers\Admin\TransferController::class, 'acceptTransfer'])->name('accept_inventory');
        Route::post('accept_transfer', [App\Http\Controllers\Admin\TransferController::class, 'createAcceptTransfer']);
        Route::get('accept_transfer/{transfer}', [App\Http\Controllers\Admin\TransferController::class, 'acceptTransfer'])->name('accept_inventory');

        #stock
        Route::resource('stocks', App\Http\Controllers\Admin\StockController::class)->only('index', 'show', 'destroy');
        Route::post('/stocks/createOrUpdate', [App\Http\Controllers\Admin\StockController::class, 'createOrUpdate']);
        #inventory
        Route::resource('inventories', App\Http\Controllers\Admin\InventoryController::class)->only('index', 'show', 'destroy');
        Route::post('/inventories/createOrUpdate', [App\Http\Controllers\Admin\InventoryController::class, 'createOrUpdate']);
        Route::delete('/shelves/{shelf}', [App\Http\Controllers\Admin\InventoryController::class, 'destroyShelf']);
        Route::post('/inventories/is_available', [App\Http\Controllers\Admin\InventoryController::class, 'changeInventoryIsAvailable']);
        Route::get('/get_floor_by_inventory', [App\Http\Controllers\Admin\FloorController::class, 'getFloorByInventory'])->name('floor_list_by_inventory'); #it doesn't need to move web that
        Route::view('/order_lists', 'order.assign_delivery')->name('order_lists'); #order admin
        Route::post('orders/save_delivery_man', [OrderController::class, 'saveDeliveryMan']);
        Route::get('order_list_by_inventory', [OrderController::class, 'ordersByInventory']); #order admin
        Route::post('inventory_order_action_status', [OrderController::class, 'actionStatusInventoryOrder']);
        //  Route::get('/get_inventories', [App\Http\Controllers\Admin\InventoryController::class, 'getInventory']);
        //  Route::view('/sale-return-lists', 'sale_return_lists.index')->name('sale_return_lists');

    });
    Route::group(['middleware' => ['permission-access:admin-management']], function () {
        Route::view('/user_lists', 'user.index')->name('users_lists');
        Route::post('/admins/change_password', [App\Http\Controllers\Admin\AdminController::class, 'changePassword']);

        #user list
        Route::resource('users', App\Http\Controllers\Admin\UserController::class)->only('index', 'show');
        Route::Post('/change_is_archive', [App\Http\Controllers\Admin\UserController::class, 'changeUserIsArchive']);

        #township
        Route::get('get_townships', [TownshipController::class, 'getTownships']);
        Route::post('/townships/createOrUpdate', [TownshipController::class, 'createOrUpdate']);

        #division
        Route::resource('divisions', DivisionController::class)->only('index');
        Route::get('get_divisions', [DivisionController::class, 'getDivisions']);

        #admin
        Route::post('/admins/createOrUpdate', [App\Http\Controllers\Admin\AdminController::class, 'createOrUpdate']);
        Route::resource('admins', App\Http\Controllers\Admin\AdminController::class)->only('index', 'show', 'destroy');
        Route::get('/departments', [App\Http\Controllers\Admin\AdminController::class, 'getDepartmentList']);
        #delivery_fee depend on townships
        //    Route::view('/townships_list', 'delivery_fees.index');
        //    Route::view('/ads_type_list', 'ads.ads_type_list');
        //    Route::view('/size_list', 'size.size_list');

        //    Route::get('/get_ads_type_list', [App\Http\Controllers\Admin\AdsController::class, 'getAdsTypeList']);
        // Route::get('/ads_type_list/{ads_type}', [App\Http\Controllers\Admin\AdsController::class, 'editAdsType']);
        // Route::post('/get_ads_type_list/create_or_update', [App\Http\Controllers\Admin\AdsController::class, 'createOrUpdateAdsType']);

        Route::get('/townships_create', function () {
            return view('delivery_fees.create', ['isediting' => 'create']);
        });
        Route::get('/townships_edit', function () {
            return view('delivery_fees.create', ['isediting' => 'edit']);
        });

    });
    Route::group(['middleware' => ['permission-access:customer-support-management']], function () {
        #ticket
        Route::view('/support_box', 'support_box.index');
        Route::view('/reply_ticket/{id}', 'support_box.reply');
        Route::post('support_ticket/toggle_support_ticket', [WebSupportTicketController::class, 'toggleSupportTicket']);
        Route::resource('support_tickets', WebSupportTicketController::class)->only('index', 'store', 'show', 'destroy');
        Route::get('get_replies', [WebSupportTicketController::class, 'getReplies']);
        Route::post('/reply_ticket/create', [SupportTicketController::class, 'replyTicket']);
    });

    Route::group(['middleware' => ['permission-access:order-management']], function () {

        #order
        Route::resource('orders', OrderController::class)->only('show', 'destroy'); #received ,confirmed,cancelled,delivering,delivered
        //  Route::get('order_list_by_inventory', [OrderController::class, 'ordersByInventory']);
        //  Route::post('orders/action_status', [OrderController::class, 'actionStatus']);
        Route::delete('orders/delete_order_item/{order_item_id}', [OrderController::class, 'deleteOrderItem']);
        //  Route::post('orders/save_delivery_man', [OrderController::class, 'saveDeliveryMan']);
        // Route::view('/order', 'order.index')->name('order');
        // Route::view('/sale-return-lists', 'sale_return_lists.index')->name('sale_return_lists');
        // Route::get('sale_return_list',[SaleReturnController::class,'index']);
        // Route::get('get_available_floor_by', [OrderController::class, 'getReplies']);
    });

    Route::group(['middleware' => ['permission-access:promotion-management']], function () {
        #view
        Route::view('/discount_index', 'delivery_promotion.index');
        Route::get('/flash-sale', function () {
            return view('flashsale_discount.index');
        })->name('flash_sale');

        #coupon
        Route::view('/coupon', 'coupon.index');
        Route::view('/coupon/create', 'coupon_management.create_private', ['isediting' => 'create']);
        Route::view('/coupon/edit/{id}', 'coupon_management.create_private', ['isediting' => 'edit']);
        Route::view('/promotion', 'promotion.index');
        Route::view('/promotion/create', 'promotion.create');
        #end

        #api
        Route::get('/discount_index/create', function () {
            return view('promotion.create', ['isediting' => 'create']);
        });
        Route::get('/discount_index/edit/{id}', function () {
            return view('promotion.create', ['isediting' => 'edit']);
        });
        Route::get('/flash-sale/create', function () {
            return view('flashsale_discount.create', ['isediting' => 'create']);
        });
        Route::get('/flash-sale/edit/{id}', function () {
            return view('flashsale_discount.create', ['isediting' => 'edit']);
        });

        #discount
        Route::resource('discounts', App\Http\Controllers\Admin\DiscountController::class)->only('index', 'show', 'destroy');
        Route::post('/discounts/createOrUpdate', [App\Http\Controllers\Admin\DiscountController::class, 'createOrUpdate']);
        Route::get('/get_discount_type', [App\Http\Controllers\Admin\DiscountController::class, 'getDiscountType']);
        Route::post('/discounts/validate_sub_product', [App\Http\Controllers\Admin\DiscountController::class, 'validateSubProduct']);

        #end discount
        #campaign
        Route::resource('campaigns', CampaignController::class)->only('index', 'show', 'destroy');
        Route::post('/campaigns/createOrUpdate', [App\Http\Controllers\Admin\CampaignController::class, 'createOrUpdate']);

        #end
        #flash_sale

        Route::post('/flash_sales/createOrUpdate', [FlashSaleController::class, 'createOrUpdate']);

        #coupon
        Route::resource('coupons', CouponController::class)->only('index', 'show', 'destroy');
        Route::post('/coupon/createOrUpdate', [CouponController::class, 'createOrUpdate']);
        Route::get('get_coupon_feature', [CouponController::class, 'getCouponFeature']);
        Route::get('get_coupon_type', [CouponController::class, 'getCouponType']);
        Route::get('get_coupon_discount_type', [CouponController::class, 'getCouponDiscountType']);

        // Route::resource('coupons',CouponController::class)->only('index');
        // Route::get('get_coupon_feature',[CouponController::class,'getCouponFeature']);

        #validate flash _sale
        Route::resource('flash_sales', FlashSaleController::class)->only('index', 'store', 'show', 'destroy');
        Route::get('delete_item', [FlashSaleController::class, 'deleteItem']);
        Route::post('/flash_sales/is_available', [FlashSaleController::class, 'changeFlashSaleIsAvailable']);
        Route::post('/flash_sale/validate_sub_product', [FlashSaleController::class, 'validateSubProduct']);

        // Route::get('/discounts',ph[App\Http\Controllers\Admin\DiscountController::class,'index']);

        #discount promotion
        Route::get('/get_promotion_category', [ProductController::class, 'getPromotionCategory']);
        Route::get('/get_sub_product_by_series_and_brand', [StockController::class, 'getSubProductBySeriesAndBrand']);

        Route::get('/get_item_with_type_in_stock', [StockController::class, 'getItemWithTypeInStock']);
        // Route::view('/delivery_promotion/create', 'delivery_promotion.create');
        #end promotion
    });

    Route::view('/product_detail', 'product.create_price&image_2nd');

    Route::view('/home_page', 'home_page.index');

    // Route::post('/admins/change_password',[App\Http\Controllers\Admin\AdminController::class,'changePassword']);

    #end

    // Route::get('/measurements', function(){
    //     $measurements = Measurement::orderBy('created_at', 'desc')->select('id', 'name')->get();
    //     responseData('data', $measurements, 200);
    // });

    #unit type
    // Route::get('/unit_types', function () {
    //     $unit_types = UnitType::with('units')->orderBy('created_at', 'desc')->get();
    //     responseData('data', $unit_types, 200);
    // });

    //* fix routes from api

    #country
    Route::get('/countries', [CountryController::class, 'getAllCountries']);
    Route::get('/countries/{country}', [CountryController::class, 'getCountry']);

    #delivery_free
    Route::view('/delivery_men_lists', 'delivery_man.index')->name('delivery_men_lists');
    Route::view('/delivery_men_lists/create', 'delivery_man.create');
    Route::view('/delivery_men_lists/edit/{id}', 'delivery_man.edit');

    #stock

    Route::view('/create_admin', 'admin.create');
    Route::view('/admin_users', 'admin_users.index')->name('admin_users.index');
    Route::view('/admin_users/create', 'admin_users.create');
    Route::view('/admin_users/edit/{id}', 'admin_users.edit');

    Route::view('/delivery', 'delivery_fees.index');
    Route::view('/delivery/create', 'delivery_fees.create'); //isediting

    Route::view('/size_chart', 'sizeguide.index')->name('size_chart.index');
    Route::view('/size_chart/create', 'sizeguide.create');

    Route::get('/get_size_chart_regions', [SizeChartController::class, 'getSizeChartRegions']);
    Route::get('/get_size_guides', [SizeChartController::class, 'getSizeGuides']);
    Route::get('/get_size_charts', [SizeChartController::class, 'getSizeCharts']);

    Route::post('/delete_size_guide', [SizeChartController::class, 'deleteSizeGuide']);
    Route::get('/size_chart/{size_guide}', [SizeChartController::class, 'updateSizeGuide']);

    Route::post('/create_size_chart', [SizeChartController::class, 'createSizeChart']);
    Route::post('/update_size_chart', [SizeChartController::class, 'updateSizeChart']);
    Route::post('/delete_size_chart', [SizeChartController::class, 'deleteSizeChart']);
    Route::post('/create_size_guide', [SizeChartController::class, 'createSizeGuide']);

    Route::view('/noti', 'notification.index');

    Route::view('/sale-return-lists', 'sale_return_lists.index')->name('sale_return_lists');
    Route::get('sale_return_list',[SaleReturnController::class,'index']);
    Route::get('/get_inventories', [App\Http\Controllers\Admin\InventoryController::class, 'getInventory']);
    Route::view('/order', 'order.index')->name('order');
});


Route::get('get_admin_type', [AdminController::class, 'getAdminType']);
Route::get('get_permission', [AdminController::class, 'getPermission']);

#delivery
Route::get('get_delivery_men', [DeliveryManController::class, 'getDeliveryMen']);
#user
Route::get('get_user', [UserController::class, 'getUser']);

#type=>product,style,brands,series,sub_categories

Route::get('/login/google', [SocailiteController::class, 'loginGoogle']);
Route::get('/google_callback', [SocailiteController::class, 'callbackGoogle']);
Route::get('/login/facebook', [SocailiteController::class, 'loginFacebook']);
Route::get('/facebook_callback', [SocailiteController::class, 'callbackFacebook']);

Route::get('/facebook_delete', [SocailiteController::class, 'delete']);
Route::get('/google_delete', [SocailiteController::class, 'delete']);

Route::view('/link', 'link.index');

// Route::view('/admin_stock', 'admin_inventory_list.index');
// Route::view('/admin_stock/create', 'admin_inventory_list.create');
// Route::get('/test_transfer_id', [SocailiteController::class, 'transferCreateView']);

Route::get('/test_json', [TownshipController::class, 'test_json']);

// Route::view('/coupon', 'coupon.index');
// Route::view('/coupon/create', 'coupon_management.create_private', ['isediting' => 'create']);
// Route::view('/coupon/edit/{id}', 'coupon_management.create_private', ['isediting' => 'edit']);
// Route::view('/promotion', 'promotion.index');
// Route::view('/promotion/create', 'promotion.create');

// Route::view('/coupon_private', 'coupon_management.create_private');

Route::view('/chats', 'chats.index');

Route::get('token', [OrderController::class, 'getToken']);

// Route::view('/size_chart', 'size_chart.index');
// Route::view('/size_chart/create', 'size_chart.create');
Route::view('/invoice_edit/{sub_product_id}/{floor_id}', 'invoice_edit.index');

Route::get('/product_details', [APIProductController::class, 'getProductDetails']);

Route::post('update_sale_return_action', [SaleReturnController::class, 'updateSaleReturnAction']);





Route::view('/credit', 'credit.index');
Route::view('/related_color', 'related_color.index');

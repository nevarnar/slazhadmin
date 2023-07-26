<div class="sidebar" id="mySidebar">
    <div id="title"
        style="padding-left: 0px; padding-top: 10px;padding-bottom: 10px; font-size: 18px;text-align: center">
        <span style="color: #dee2e6"><b>Slazh</b></span>
    </div>
    <div class="inner-sidebar pb-4" style="overflow-y: auto" id="inner">
        @php
            $currentURL = url()->current();
            $currentUrlArr = explode('/', $currentURL);
            $active_side_bar = '';
            if (in_array('categories_lists', $currentUrlArr) || in_array('sub_categories_lists', $currentUrlArr) || in_array('brands_lists', $currentUrlArr) || in_array('colors_lists', $currentUrlArr) || in_array('occasions_lists', $currentUrlArr) || in_array('variations_lists', $currentUrlArr) || in_array('suppliers_lists', $currentUrlArr) || in_array('reviews', $currentUrlArr)) {
                $active_side_bar = 'product_information';
            }

            if (in_array('products_lists', $currentUrlArr) || in_array('sub_products_lists', $currentUrlArr) || in_array('style_lists', $currentUrlArr) || in_array('collection_lists', $currentUrlArr) || in_array('ads_lists', $currentUrlArr) || in_array('delivery_men_lists', $currentUrlArr)) {
                $active_side_bar = 'product';
            }
            if (in_array('inventory_lists', $currentUrlArr) || in_array('stocks_lists', $currentUrlArr) || in_array('defect_confirm_lists', $currentUrlArr) || in_array('defect_lists', $currentUrlArr) || in_array('invoice_lists', $currentUrlArr)) {
                $active_side_bar = 'inventory';
            }
            if (in_array('discount_index', $currentUrlArr) || in_array('campaign_view', $currentUrlArr) || in_array('flash-sale', $currentUrlArr) || in_array('coupon', $currentUrlArr)) {
                $active_side_bar = 'promotion';
            }
            if (in_array('support_box', $currentUrlArr)) {
                $active_side_bar = 'customer_support';
            }
            if (in_array('townships_list', $currentUrlArr)) {
                $active_side_bar = 'townships_list';
            }
           
            if (in_array('order', $currentUrlArr) || in_array('order', $currentUrlArr)) {
                $active_side_bar = 'order';
            }
        @endphp

            <div class="contents">
                @if (Auth::user()->hasPermission('admin-management') || Auth::user()->isSuperAdmin())
                <div class="sidebar-group-container">
                    <div class="">
                        <!-- <p class="sidebar-group-label">Admin</p> -->
                        <a href="{{ route('admin_users.index') }}" class="a-clear list-sidebar lastchild-p-0">
                            <i class="fal fa-user pr-4"></i> Staff
                        </a>
                        <a href="{{ route('users_lists') }}" class="a-clear list-sidebar  lastchild-p-0">
                            <i class="fal fa-user pr-4"></i> Users
                        </a>
                    </div>
                </div>
                @endif
                @if (Auth::user()->hasPermission('product-information-management') || Auth::user()->isSuperAdmin())

                <div class="sidebar-group-container">
                    <div class="">
                        <!-- <p class="sidebar-group-label">Product</p> -->
                        <p class="md:space-x-1 space-y-1 md:space-y-0 mb-1">
                            <button class="list-sidebar btn-clear collapse-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fal fa-archive pr-3"></i>
                                Product Information
                                <i class="fal fa-sort-down" style="position: absolute;right: 9%;top: 8px"></i>
                            </button>
                        </p>
                        <div class="collapse <?= $active_side_bar == 'product_information' ? 'show' : '' ?>"
                            id="collapseExample" data-bs-parent="#inner">
                            <div class="block pr-6 pl-10 pb-3 pt-2" style="background:#2C303B">
                                <ul class="sidebar-ul-list mb-0">
                                    <li>
                                        <a href="{{ route('categories_lists.index') }}">Category</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('sub_categories_lists.index') }}">Sub Category</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('brands_lists.index') }}">Brand</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('colors_lists.index') }}">Color</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('occasions_lists.index') }}">Occasion</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('variations_lists.index') }}">Variation</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('suppliers_lists.index') }}">Suppliers</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('size_chart.index') }}">Size Charts</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('reviews') }}">Reviews</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar-group-container">
                    <div class="">
                        <p class="md:space-x-1 space-y-1 md:space-y-0 mb-1">
                            <button class="list-sidebar btn-clear collapse-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample2" aria-expanded="false"
                                aria-controls="collapseExample2">
                                <i class="fal fa-archive pr-3"></i>
                                Products
                                <i class="fal fa-sort-down" style="position: absolute;right: 9%;top: 8px"></i>
                            </button>
                        </p>
                        <div class="collapse  <?= $active_side_bar == 'product' ? 'show' : '' ?>" id="collapseExample2"
                            data-bs-parent="#inner">
                            <div class="block pr-6 pt-0 pl-10 pb-3" style="background:#2C303B">
                                <ul class="sidebar-ul-list mb-0 pt-3">
                                    <li>
                                        <a href="{{ route('products_lists.index') }}">Product</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('sub_products_lists.index') }}">Sub Products</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('style_lists.index') }}">Style</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('collection_lists.index') }}">Collection</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('ads_lists') }}">Ads
                                             {{-- <span class="inline-flex items-center justify-center w-4 h-4 ml-2 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                                            {{$countOfUnread}}
                                          </span> --}}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('delivery_men_lists') }}">Delivery</a>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>

        @if (Auth::user()->hasPermission('inventory-management') || Auth::user()->isSuperAdmin())
        <div class="sidebar-group-container">
            <div class="">
                <p class="md:space-x-1 space-y-1 md:space-y-0 mb-1 ">
                    <button data-mdb-ripple="true" class="list-sidebar btn-clear collapse-btn" type="button"
                        data-bs-toggle="collapse" data-bs-target="#inventory" aria-expanded="false"
                        aria-controls="inventory">
                        <i class="fal fa-archive pr-3"></i>
                        Inventory
                        <i class="fal fa-sort-down" style="position: absolute;right: 9%;top: 8px"></i>
                    </button>
                </p>
                <div class="collapse <?= $active_side_bar == 'inventory' ? 'show' : '' ?>" id="inventory"
                    data-bs-parent="#inner">
                    <div class="block pr-6 pt-0 pl-10 pb-3" style="background:#2C303B">
                        <ul class="sidebar-ul-list mb-0 pt-3 ">
                            @if (Auth::user()->isSuperAdmin())
                            <li>
                                <a href="{{ route('inventory_lists.index') }}">Inventory</a>
                            </li>
                            @endif
                            <li>
                                <a href="{{ route('instocks.index') }}">Stock</a>
                            </li>
                            @if (Auth::user()->hasPermission('admin-management'))
                                <li>
                                    <a href="{{ route('defect.confirm') }}">Defect Confirm Lists</a>
                                </li>
                            @endif

                            <li>
                                <a href="{{ route('defect.lists') }}">Defect Lists</a>
                            </li>
                            <li>
                                <a href="{{ route('invoice_lists') }}">Invoice Lists</a>
                            </li>
                            @if (Auth::user()->hasPermission('inventory-management'))
                                <li>
                                    <a href="{{ route('inventory_movement.index') }}">Inventory Transfers</a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        @if (Auth::user()->hasPermission('promotion-management') || Auth::user()->isSuperAdmin())
        <div class="sidebar-group-container">
            <div class="">
                <p class="md:space-x-1 space-y-1 md:space-y-0 mb-1 ">
                    <button data-mdb-ripple="true" class="list-sidebar btn-clear collapse-btn" type="button"
                        data-bs-toggle="collapse" data-bs-target="#promotion" aria-expanded="false"
                        aria-controls="promotion">
                        <i class="fal fa-archive pr-3"></i>
                        Promotion
                        <i class="fal fa-sort-down" style="position: absolute;right: 9%;top: 8px"></i>
                    </button>
                </p>
                <div class="collapse <?= $active_side_bar == 'promotion' ? 'show' : '' ?>" id="promotion"
                    data-bs-parent="#inner">
                    <div class="block pr-6 pt-0 pl-10 pb-3" style="background:#2C303B">
                        <ul class="sidebar-ul-list mb-0 pt-3 ">
                            <li>
                                <a href="{{ url('discount_index') }}">Discount</a>
                            </li>
                            <li>
                                <a href="{{ url('flash-sale') }}">Flash Sale</a>
                            </li>
                            <li>
                                <a href="{{ url('coupon') }}">Coupons</a>
                            </li>
                            {{-- <li>
                                <a href="{{url('campaign_view')}}">Campaign</a>
                            </li> --}}
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        @endif
        @if (Auth::user()->hasPermission('customer-support-management') || Auth::user()->isSuperAdmin())
        <div class="sidebar-group-container">
            <div class="">
                <p class="md:space-x-1 space-y-1 md:space-y-0 mb-1 ">
                    <button data-mdb-ripple="true" class="list-sidebar btn-clear collapse-btn" type="button"
                        data-bs-toggle="collapse" data-bs-target="#customer_support" aria-expanded="false"
                        aria-controls="promotion">
                        <i class="fal fa-archive pr-3"></i>
                        Customer Support
                        <i class="fal fa-sort-down" style="position: absolute;right: 9%;top: 8px"></i>
                    </button>
                </p>
                <div class="collapse <?= $active_side_bar == 'customer_support' ? 'show' : '' ?>"
                    id="customer_support" data-bs-parent="#inner">
                    <div class="block pr-6 pt-0 pl-10 pb-3" style="background:#2C303B">
                        <ul class="sidebar-ul-list mb-0 pt-3 ">
                            <li>
                                <a href="{{ url('support_box') }}">Support Ticket</a>
                            </li>
                            <li>
                                <a href="{{ url('chats') }}">Chats</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        @endif
        @if (Auth::user()->hasPermission('admin-management') || Auth::user()->hasPermission('product-information-management') || Auth::user()->isSuperAdmin())
        <div class="sidebar-group-container">
            <div class="">
                <p class="md:space-x-1 space-y-1 md:space-y-0 mb-1 ">
                    <button data-mdb-ripple="true" class="list-sidebar btn-clear collapse-btn" type="button"
                        data-bs-toggle="collapse" data-bs-target="#setup" aria-expanded="false"
                        aria-controls="promotion">
                        <i class="fal fa-archive pr-3"></i>
                        Setup
                        <i class="fal fa-sort-down" style="position: absolute;right: 9%;top: 8px"></i>
                    </button>
                </p>
                <div class="collapse <?= $active_side_bar == 'townships_list' ? 'show' : '' ?>" id="setup"
                    data-bs-parent="#inner">
                    <div class="block pr-6 pt-0 pl-10 pb-3" style="background:#2C303B">
                        <ul class="sidebar-ul-list mb-0 pt-3 ">
                            <li>
                                <a href="{{ url('townships_list') }}">Township</a>
                            </li>
                            <li>
                                <a href="{{ url('ads_type_list') }}">Ads Type List</a>
                            </li>
                            <li>
                                <a href="{{ url('size_list') }}">Size List</a>
                            </li>

                        </ul>
                    </div>
                </div>
              

            </div>
        </div>
        @endif
        @if(Auth::user()->hasPermission('order-management')|| Auth::user()->isSuperAdmin() ||Auth::user()->hasPermission('inventory-management'))
        <div class="sidebar-group-container">
            <div class="">
                <p class="md:space-x-1 space-y-1 md:space-y-0 mb-1 ">
                    <button data-mdb-ripple="true" class="list-sidebar btn-clear collapse-btn" type="button"
                        data-bs-toggle="collapse" data-bs-target="#order" aria-expanded="false"
                        aria-controls="promotion">
                        <i class="fal fa-archive pr-3"></i>
                        Order
                        <i class="fal fa-sort-down" style="position: absolute;right: 9%;top: 8px"></i>
                    </button>
                </p>
                <div class="collapse <?= $active_side_bar == 'order' ? 'show' : '' ?>" id="order"
                    data-bs-parent="#inner">
                    <div class="block pr-6 pt-0 pl-10 pb-3" style="background:#2C303B">
                        <ul class="sidebar-ul-list mb-0 pt-3 ">
                            @if (Auth::user()->hasPermission('order-management'))
                                <li>
                                    <a href="{{ url('order') }}">Orders</a>
                                </li>
                                <li>
                                    <a href="{{ url('sale-return-lists') }}">Sale Return Lists</a>
                                </li>
                            @endif
                            @if (Auth::user()->hasPermission('inventory-management') || Auth::user()->isSuperAdmin())
                                <li>
                                    <a href="{{ url('order') }}">Order List</a>
                                </li>
                                <li>
                                    <a href="{{ url('sale-return-lists') }}">Sale Return ListsI</a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>

            </div>
        </div>
        @endif

    </div>
</div>

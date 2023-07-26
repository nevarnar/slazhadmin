<div class="topbar flex justify-between">
    <a href="#" class="mb-2">
        {{--        <button onclick="openNav()" id="collapse_btn" --}}
        {{--                style="float: left; margin-top: 10px; margin-left: 228px;color: #5e6266;font-size: 14px; --}}
        {{--             border: none; padding: 6px 20px; border-radius: 5px;"> --}}
        {{--            <i class="fas fa-bars"></i> --}}
        {{--        </button> --}}
    </a>
    {{--    <a href="#" class="mb-2"> --}}
    {{--        <button --}}
    {{--            style="float: right; margin-top: 10px; margin-right: 35px;color: #5e6266;font-size: 14px; --}}
    {{--             border: none; padding: 6px 20px; border-radius: 5px;"> --}}
    {{--            Logout --}}
    {{--        </button> --}}
    {{--    </a> --}}
    <div>
        <div class="acc-container inline-block">
            <div class="inline-block">
                <button class="acc-btn" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <p class=" inline-block relative">{{ Auth::user()->full_name }}</p>
                    <img class="acc-img" src="{{ asset('img/user-5.jpg') }}" alt="">
                </button>

                <ul class="dropdown-menu acc-setting-ul" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <a class="dropdown-item acc-setting-li" href="#">Setting</a>
                    </li>
                    <li>
                        <a class="
                            dropdown-item acc-setting-li a-clear focus:bg-slate-50 mb"
                            href="/logout">Logout</a>
                    </li>

                </ul>
            </div>
        </div>

        {{-- <div class="dropdown relative inline-block ml-3 mr-8 pb-2">
            <a class="dropdown-toggle text-xl flex items-center  hidden-arrow" href="#" id="dropdownMenuButton2"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fal fa-bell"></i>
            </a>
            <div class="dropdown-menu min-w-max max-w-[40vw] overflow-y-auto h-[85vh] absolute hidden nav-ul"
                aria-labelledby="dropdownMenuButton2">
                <ul>
                    <p class=" nav-ul-a pl-8 text-sm hover:bg-transparent">
                        Slazh Notification
                    </p>
                    <hr class="h-0 my-2 border border-solid border-t-0 border-gray-700 opacity-25 w-[90%] ml-[5%]" />
                    <li class="px-4">
                        <a class=" nav-ul-a pt-0" href="#" style="border-bottom:1px solid rgba(228, 228, 228, 1)">
                            <p class=" nav-ul-a pl-0 pb-1">
                                Marketing Message Title
                            </p>
                            <p class=" break-words whitespace-normal w-96 text-gray-400 mb-2">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe, est. Explicabo ipsa
                                error ducimus eaque
                            </p>
                            <p class="text-[13px] text-stone-700 leading-5">
                                12 Hours Ago
                            </p>
                        </a>
                    </li>
                    <li class="px-4">
                        <a class=" nav-ul-a pt-0" href="#" style="border-bottom:1px solid rgba(228, 228, 228, 1)">
                            <p class=" nav-ul-a pl-0 pb-1">
                                Marketing Message Title
                            </p>
                            <p class=" break-words whitespace-normal w-96 text-gray-400 mb-2">
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe, est. Explicabo ipsa
                                error ducimus eaque
                            </p>
                            <p class="text-[13px] text-stone-700 leading-5">
                                12 Hours Ago
                            </p>
                        </a>
                    </li>
                    <hr class="h-0 mb-2 border border-solid border-t-0 border-gray-700 opacity-25" />
                </ul>
                <ul>
                    <li>
                        <p class=" nav-ul-a pl-8 hover:bg-transparent">
                            Order Status
                        </p>
                    </li>
                    <li class="px-4">
                        <a class=" nav-ul-a pb-3 mb-0 text-gray-400 flex justify-between"
                            style="border-bottom:1px solid rgba(228, 228, 228, 1)" href="#">
                            <div>
                                <img src="/img/jean_pant.jpg" class=" w-16 h-16 inline-block" alt="">
                                <div class=" inline-block">
                                    <p class=" w-2/5 mb-2 primary-font">
                                        Order Number 101
                                    </p>
                                    <p class="text-[13px] text-stone-700 leading-5">
                                        4 feb 2022
                                    </p>
                                </div>
                            </div>
                            <p class="text-[13px] text-stone-700 leading-5">
                                3 Days Ago
                            </p>
                        </a>

                    </li>
                    <hr class="h-0 mb-2 border border-solid border-t-0 border-gray-700 opacity-25" />
                </ul>
                <ul>
                    <li>
                        <p class=" nav-ul-a pl-8 hover:bg-transparent">
                            Customer Support
                        </p>
                    </li>
                    <li class="px-4">
                        <a class=" nav-ul-a pb-3 mb-0 text-gray-400 flex justify-between"
                            style="border-bottom:1px solid rgba(228, 228, 228, 1)" href="#">
                            <div>

                                <p class=" w-2/5 mb-2 primary-font pr-4">
                                    A New Reply was arrived in your support ticket #1234
                                </p>
                            </div>
                            <p class="text-[13px] text-stone-700 leading-5">
                                3 Days Ago
                            </p>
                        </a>

                    </li>
                    <hr class="h-0 mb-2 border border-solid border-t-0 border-gray-700 opacity-25" />
                </ul>
                <ul>
                    <li>
                        <p class=" nav-ul-a pl-8 hover:bg-transparent">
                            Coupon
                        </p>
                    </li>
                    <li class="px-4">
                        <a class=" nav-ul-a pb-3 mb-0 text-gray-400 flex justify-between" href="#">
                            <div>
                                <img src="/img/jean_pant.jpg" class=" w-16 h-16 inline-block" alt="">
                                <div class=" inline-block">
                                    <p class=" w-2/5 mb-2 primary-font text-stone-700">
                                        You received new coupon
                                    </p>
                                    <p class="text-[13px] text-gray-400 leading-5">
                                        Coupon Name
                                    </p>
                                </div>
                            </div>
                            <p class="text-[13px] text-stone-700 leading-5">
                                3 Days Ago
                            </p>

                        </a>

                    </li>
                    <hr class="h-0 mb-2 border border-solid border-t-0 border-gray-700 opacity-25" />
                </ul>
                <a class="dropdown-item nav-ul-a text-center" href="#">See all Notification</a>
            </div>
        </div> --}}
        <notifications></notifications>
    </div>

</div>

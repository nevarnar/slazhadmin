@extends('layouts.main')
@section('title', ' Notification')
@section('content')

<div class="inner-main-container">
    <div>
        <p class="page-tittle">Notification</p>
    </div>

    <div class="mt-6">
        <ul class="nav ml-3 noti-tabs space-x-7 flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-4 mb-1"
            id="tabs-tab" role="tablist">
            
            <li class="nav-item nav-link text-gray-500" role="presentation">
                <a href="#tabs-order" class=" active noti-link
                         text-sm
                        " id="tabs-order-btn" data-bs-toggle="pill" data-bs-target="#tabs-order" role="tab"
                    aria-controls="tabs-processing" aria-selected="false">
                    Orders
                </a>
            </li>
            <li class="nav-item text-gray-500" role="presentation">
                <a href="#tabs-ticket" class=" noti-link
                         text-sm
                        " id="tabs-ticket-btn" data-bs-toggle="pill" data-bs-target="#tabs-ticket" role="tab"
                    aria-controls="tabs-ticket" aria-selected="false">
                    Support Ticket
                </a>
            </li>
        </ul>
        <div class="tab-content" id="tabs-tabOrder">
            
            <div class="tab-pane fade show active" id="tabs-order" role="tabpanel" aria-labelledby="tabs-order-btn">
                <ul>
                    <li class="px-4">
                        <a class=" nav-ul-a pb-4" href="#" style="border-bottom:1px solid rgba(228, 228, 228, 1)">
                            <p class=" nav-ul-a pl-0 pb-1 text-left">
                                A New Order is arrived. #123456
                            </p>
                            <p class="text-[13px] text-gray-500 leading-5 text-left">
                                12 Hours Ago
                            </p>
                        </a>
                    </li>
                    <li class="px-4 ">
                        <a class=" nav-ul-a pb-4" href="#" style="border-bottom:1px solid rgba(228, 228, 228, 1)">
                            <p class=" nav-ul-a pl-0 pb-1 text-left">
                                A New Order is arrived. #123456
                            </p>
                            <p class="text-[13px] text-gray-500 leading-5 text-left">
                                12 Hours Ago
                            </p>
                        </a>
                    </li>
                    <!-- <hr class="h-0 my-2 border border-solid border-t-0 border-gray-700 opacity-25 w-[90%] ml-[5%]" /> -->
                </ul>
            </div>
            
            <div class="tab-pane fade" id="tabs-ticket" role="tabpanel" aria-labelledby="tabs-ticket-btn">
                <ul>
                    <li class="px-4 ">
                        <a class=" nav-ul-a pb-4" href="#" style="border-bottom:1px solid rgba(228, 228, 228, 1)">
                            <p class=" nav-ul-a pl-0 pb-1 text-left">
                                A new support ticket is arrived
                            </p>
                            <p class="text-[13px] text-gray-400 leading-5 text-left">
                                A new reply is arrived in support ticket. #123456
                            </p>
                        </a>
                    </li>
                    <li class="px-4 ">
                        <a class=" nav-ul-a pb-4" href="#" style="border-bottom:1px solid rgba(228, 228, 228, 1)">
                            <p class=" nav-ul-a pl-0 pb-1 text-left">
                                A new support ticket is arrived
                            </p>
                            <p class="text-[13px] text-gray-400 leading-5 text-left">
                                A new reply is arrived in support ticket. #123456
                            </p>
                        </a>
                    </li>
                    <!-- <hr class="h-0 my-2 border border-solid border-t-0 border-gray-700 opacity-25 w-[90%] ml-[5%]" /> -->
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

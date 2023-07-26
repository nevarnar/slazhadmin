@extends('layouts.main')
@section('title', ' Assign to Delivery')
@section('content')

    <order-lists-by-inventory />
    {{--
<div class="inner-main-container">
        <div class="flex justify-between">
            <p class="page-tittle pt-2"> Assign to Delivery</p>

            <div>

            </div>
        </div>
        <div class="relative flex justify-between">
            <div class="flex">

                <div class="list-component">
                    <SearchBox
                        :mutationName="mutationName"
                        :pagination-url="paginationUrl"
                        search-web="web"
                    />
                </div>
                <div class="list-component">
                    <multiselect
                        :options="seriesOptions"
                        :searchable="false"
                        :close-on-select="true"
                        :show-labels="false"
                        :allow-empty="true"
                        track-by="id"
                        :custom-label="customLabel"
                        placeholder="Series"
                    ></multiselect>
                </div>


            </div>
        </div>
        <div class="block pb-8">
            <table class="table-auto primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Item Count</th>
                        <th>Total Price</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <div
                        style="display: contents"
                        >
                        <tr>
                            <td>1</td>
                            <td>
                                T101-111
                            </td>
                            <td>20 May 2022</td>
                            <td>
                                John Cena
                            </td>
                            <td class=" w-64 px-2 whitespace-normal break-words" style="text-align:left">
                                No.123, 8th Floor , Corner of Tha Di Pa Htan & Thila Road , South Oakkalar
                            </td>
                            <td>
                                3
                            </td>
                            <td>3000</td>
                            <td>
                                <select class=" rounded-xl px-3 py-1 bg-black text-white text-xs"  data-bs-toggle="collapse"
                                    data-bs-target="#detail"
                                    aria-expanded="false"
                                    aria-controls="detail">
                                    <option value="" >Assign Delivery Man</option>
                                    <option value="">Delivery</option>
                                </select>
                                <!-- <button
                                    data-bs-toggle="collapse"
                                    data-bs-target="#detail"
                                    aria-expanded="false"
                                    aria-controls="detail"
                                >
                                    <i class="fal fa-list"></i>
                                </button> -->
                            </td>
                        </tr>

                        <tr class="collapse border-b-0" id="detail">
                            <td colspan="9" class=" border-b-0 border-l-[6px] border-gray-600">
                                <div class="relative flex w-full pt-3">
                                    <div class="pr-4 pt-3 pl-10 pb-6 bg-inherit inline-block relative">
                                        <img src="{{ asset('img/sweater.png') }}" class="aspect-[2/3]" alt=""/>
                                    </div>

                                    <div class="w-full flex flex-row">
                                        <div class="w-max">
                                            <div class="flex justify-start pl-4 pt-4">
                                                <p class="text-sm text-gray-700 inline-block w-12 min-w-max text-left"
                                                    style="font-family: 'Roboto',sans-serif;">
                                                    H&M 101 Pant
                                                </p>
                                            </div>
                                            <div class="flex justify-start pl-4 pt-4">
                                                <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                                                    style="font-family: 'Roboto',sans-serif;">
                                                    Color
                                                </p>
                                                <span class="px-3"> : </span>
                                                <p class="text-sm text-gray-500 inline-block">
                                                    Red
                                                </p>
                                            </div>
                                            <div class="flex justify-start pl-4 py-2">
                                                <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                                                    style="font-family: 'Roboto',sans-serif;">
                                                    Size
                                                </p>
                                                <span class="px-3"> : </span>
                                                <p class="text-sm text-gray-500 inline-block">
                                                    123
                                                </p>
                                            </div>
                                        </div>

                                        <div class="pl-8 pt-3.5 w-full">
                                            <table class="secondary-table">
                                                <thead class="secondary-table-thead">
                                                    <tr>
                                                        <th class="sec-thead-th"
                                                            style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                                            Count
                                                        </th>
                                                        <th class="sec-thead-th"
                                                            style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                                            SKU
                                                        </th>
                                                        <th
                                                            class="sec-thead-th"
                                                            style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                                        </th>
                                                        <th class="sec-thead-th"
                                                            style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                                        </th>
                                                        <th class="sec-thead-th"
                                                            style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="sec-table-td">
                                                            2
                                                        </td>
                                                        <td class="sec-table-td">
                                                            aca-21-zxy-a101
                                                        </td>
                                                        <td class="sec-table-td">
                                                        </td>
                                                        <td colspan="2" class="sec-table-td">

                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <hr class="h-0 my-2">
                                <div class="relative flex w-full pt-3">
                                    <div class="pr-4 pt-3 pl-10 pb-6 bg-inherit inline-block relative">
                                        <img src="{{ asset('img/sweater.png') }}" class="aspect-[2/3]" alt=""/>
                                    </div>

                                    <div class="w-full flex flex-row">
                                        <div class="w-max">
                                            <div class="flex justify-start pl-4 pt-4">
                                                <p class="text-sm text-gray-700 inline-block w-12 min-w-max text-left"
                                                    style="font-family: 'Roboto',sans-serif;">
                                                    H&M 101 Pant
                                                </p>
                                            </div>
                                            <div class="flex justify-start pl-4 pt-4">
                                                <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                                                    style="font-family: 'Roboto',sans-serif;">
                                                    Color
                                                </p>
                                                <span class="px-3"> : </span>
                                                <p class="text-sm text-gray-500 inline-block">
                                                    Red
                                                </p>
                                            </div>
                                            <div class="flex justify-start pl-4 py-2">
                                                <p class="text-sm text-gray-800 inline-block w-12 min-w-max text-left"
                                                    style="font-family: 'Roboto',sans-serif;">
                                                    Size
                                                </p>
                                                <span class="px-3"> : </span>
                                                <p class="text-sm text-gray-500 inline-block">
                                                    123
                                                </p>
                                            </div>
                                        </div>

                                        <div class="pl-8 pt-3.5 w-full">
                                            <table class="secondary-table">
                                                <thead class="secondary-table-thead">
                                                    <tr>
                                                        <th class="sec-thead-th"
                                                            style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                                            Count
                                                        </th>
                                                        <th class="sec-thead-th"
                                                            style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                                            SKU
                                                        </th>
                                                        <th
                                                            class="sec-thead-th"
                                                            style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                                        </th>
                                                        <th class="sec-thead-th px-0 w-36"
                                                            style="padding-top: 0.25rem;padding-bottom: 0.25rem;">
                                                        </th>
                                                        <th class="sec-thead-th"
                                                            style="padding-top: 0.25rem;padding-bottom: 0.25rem;">

                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="sec-table-td">
                                                            2
                                                        </td>
                                                        <td class="sec-table-td">
                                                            aca-21-zxy-a101
                                                        </td>
                                                        <td class="sec-table-td">
                                                        </td>
                                                        <td colspan="2" class="sec-table-td">

                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </div>
                    <tr>
                            <td>1</td>
                            <td>
                                T101-111
                            </td>
                            <td>20 May 2022</td>
                            <td>
                                John Cena
                            </td>
                            <td class=" w-64 px-2 whitespace-normal break-words" style="text-align:left">
                                Aung Myae Thar San , MDY
                            </td>
                            <td>
                                3
                            </td>
                            <td>3000</td>
                            <td>
                                <select class=" rounded-xl  px-3 py-1 bg-black text-white text-xs"  data-bs-toggle="collapse"
                                    data-bs-target="#detail2"
                                    aria-expanded="false"
                                    aria-controls="detail2">
                                    <option value="" >Delivery</option>
                                    <option value="">Assign Delivery Man</option>
                                </select>
                                <!-- <button
                                    data-bs-toggle="collapse"
                                    data-bs-target="#detail"
                                    aria-expanded="false"
                                    aria-controls="detail"
                                >
                                    <i class="fal fa-list"></i>
                                </button> -->
                            </td>
                        </tr>
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedWebData"
                :max-visible-buttons="20"
                :mutationName="mutationName"
                :pagination-url="paginationUrl"
            />
        </div>
</div> --}}



@endsection

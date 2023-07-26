@extends('layouts.main')
@section('title', ' Order Confirm')
@section('content')


<!-- 'item waiting from supplier -> confiming order' in figma -->

    <div class="inner-main-container">
        <div>
            <p class="page-tittle text-black text-sm">Invoice Form</p>
        </div>
        <div class="flex flex-row mt-4 pb-2 space-x-6">
            <div class="flex-none w-fit">
                <p class=" text-gray-900 text-13px mb-1">
                    Invoice Number
                </p>
                <p class=" text-gray-400 text-13px">
                    1123
                </p>
            </div>
            <div class="flex-none w-fit">
                <p class=" text-gray-900 text-13px mb-1">
                    Supplier Name
                </p>
                <p class=" text-gray-400 text-13px capitalize">
                     Mr.Kane
                </p>
            </div>
            <div class="flex-none w-fit mr-2">
                <p class=" text-gray-900 text-13px mb-1">
                    Date
                </p>
                <p class=" text-gray-400 text-13px">
                    13 / 11 /2021
                </p>
            </div>
        </div>
        <hr class="my-2 h-0.5 mb-4">


        <div class="relative block mb-2">
            <p class="page-tittle text-black text-13px">Order List</p>
        </div>
        <div class="block pb-8">
            <table class=" w-full overflow-hidden">
                <thead class="">
                    <tr>
                        <th class="pr-5 pl-3 py-2 text-xs text-gray-800 font-normal text-left">
                            Item Code
                        </th>
                        <th class="px-6 py-2 text-xs text-gray-800 font-normal">
                            Product Name
                        </th>
                        <th class="px-6 py-2 text-xs text-gray-800 font-normal">
                            Brand
                        </th>
                        <th class="px-6 py-2 text-xs text-gray-800 font-normal">
                            Sub Category
                        </th>
                        <th class="px-6 py-2 text-xs text-gray-800 font-normal">
                            Product Size
                        </th>
                        <th class="px-6 py-2 text-xs text-gray-800 font-normal">
                            Quantity
                        </th>
                    </tr>        
                </thead>
                <tbody class="bg-white">
                    <tr class="whitespace-nowrap">
                        <td class="pr-5 pl-3 py-1.5 text-gray-500 text-table text-left">
                                1001
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Levis Pants
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Levis
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Pants
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                16
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                10
                            </div>
                        </td>
                    </tr>
                    <tr class="whitespace-nowrap">
                        <td class="pr-5 pl-3 py-1.5 text-gray-500 text-table text-left">
                                1001
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Levis Pants
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Levis
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Pants
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                16
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                10
                            </div>
                        </td>
                    </tr>
                    <tr class="whitespace-nowrap">
                        <td class="pr-5 pl-3 py-1.5 text-gray-500 text-table text-left">
                                1001
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Levis Pants
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Levis
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Pants
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                16
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                10
                            </div>
                        </td>
                    </tr>
                    <tr class="whitespace-nowrap">
                        <td class="pr-5 pl-3 py-1.5 text-gray-500 text-table text-left">
                                1001
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Levis Pants
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Levis
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Pants
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                16
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                10
                            </div>
                        </td>
                    </tr>
                    <tr class="whitespace-nowrap">
                        <td class="pr-5 pl-3 py-1.5 text-gray-500 text-table text-left">
                                1001
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Levis Pants
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Levis
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Pants
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                16
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                10
                            </div>
                        </td>
                    </tr>
                    <tr class="whitespace-nowrap">
                        <td class="pr-5 pl-3 py-1.5 text-gray-500 text-table text-left">
                                1001
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Levis Pants
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Levis
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                Pants
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                16
                            </div>
                        </td>
                        <td class="px-5 py-1.5">
                            <div class=" text-gray-500 text-table">
                                10
                            </div>
                        </td>
                    </tr>
                    
                    

                </tbody>
            </table>

            <di class="flex justify-end mt-4">
                    <button type="button" class=" primary-button
                    bg-black">
                    Action
                    </button>
                </div>
        </div>
    </div>

@endsection

@extends('layouts.main')
@section('title', ' Edit Purchase Order')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Edit Order Form</p>
        </div>
        <div class="pt-6 mb-6">
            <div class=" grid grid-cols-9 gap-y-2 gap-x-8 mx-2">
                <div class="col-span-2">
                    <label for="" class="form-label label-form">Invoice Number</label>
                </div>
                <div class="col-span-2">
                    <label for="" class="form-label label-form">Supplier Name</label>
                </div>
                <div class="col-span-2">
                    <label for="" class="form-label label-form">Sub Category SKU Name</label>
                </div>
                <div class="col-span-3">
                    <!-- free space for grid -->
                </div>

                <!-- start row -->
                <div class="col-span-2">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-2
                                block w-full px-3 py-1.5 text-gray-700
                                bg-white bg-clip-padding border border-solid border-gray-300
                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                               id="" placeholder="Invoice Number">
                    </div>
                </div><div class="col-span-2">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-2
                                block w-full px-3 py-1.5 text-gray-700
                                bg-white bg-clip-padding border border-solid border-gray-300
                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                               id="" placeholder="Supplier Name">
                    </div>
                </div><div class="col-span-2">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-2
                                block w-full px-3 py-1.5 text-gray-700
                                bg-white bg-clip-padding border border-solid border-gray-300
                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                               id="" placeholder="12 / 2 /2022">
                    </div>
                </div>
                <div class="col-span-3">
                     <!-- free space for grid  -->
                </div>
                <!-- end row -->

                <div class="col-span-9">
                    <label for="" class="form-label label-form">Invoice Number</label>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-2
                                block w-full px-3 py-1.5 text-gray-700
                                bg-white bg-clip-padding border border-solid border-gray-300
                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                               id="engName" placeholder="Invoice Number">
                    </div>
                </div>
                <div class="col-span-7">
                    <div class="form-group mt-2">
                        <button class="text-13px btn-clear">Add</button>
                    </div>
                </div>
                <div class=" col-span-9">
                    <hr class="my-2 h-0.5">
                </div>
            </div>


            <div class="flex justify-between mt-2">
                <div>
                    <p class="page-tittle text-sm pl-2">Product Information</p>
                </div>
                <div>
                    <button type="button" class="btn-clear mr-2" title="" id="">
                        <a href="#" class="a-clear">
                            <i class="fal fa-check fw300" style="color:#68728c;"></i>
                        </a>
                    </button>
                    <button type="button" class="btn-clear" title="Error" id="error-button" data-bs-toggle="modal"
                        data-bs-target="#error_modal">
                        <i class="fal fa-times fw300 w-4" style="color:#68728c;"></i>
                    </button>
                </div>
            </div>

            <!-- start row -->
            <div class=" grid grid-cols-9 gap-y-2 gap-x-8 mx-2">
                <div class="col-span-2">
                        <label for="" class="form-label label-form">Quantity</label>
                </div>
                <div class="col-span-2">
                        <label for="" class="form-label label-form">Buying Price</label>
                </div>
                <div class="col-span-5">
                        <!-- free space for grid -->
                </div>

                
                <div class="col-span-2">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-2
                                block w-full px-3 py-1.5 text-gray-700
                                bg-white bg-clip-padding border border-solid border-gray-300
                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                               id="" placeholder="Quantity">
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-2
                                block w-full px-3 py-1.5 text-gray-700
                                bg-white bg-clip-padding border border-solid border-gray-300
                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                               id="" placeholder="Buying Price">
                    </div>
                </div>
                
                <div class="col-span-5">
                     <!-- free space for grid  -->
                </div>
            </div>  
                <!-- end row -->

                
                
            <!-- start row -->
            <div class="flex flex-row mt-4 pb-2 space-x-8 ml-2">
                <div class="flex-none w-fit">
                    <p class=" text-gray-900 text-13px mb-1">
                        Product Name
                    </p>
                    <p class=" text-gray-400 text-13px">
                        Levis Pants
                    </p>
                </div>
                <div class="flex-none w-fit">
                    <p class=" text-gray-900 text-13px mb-1">
                        Brand
                    </p>
                    <p class=" text-gray-400 text-13px capitalize">
                        Levis
                    </p>
                </div>
                <div class="flex-none w-fit mr-2">
                    <p class=" text-gray-900 text-13px mb-1">
                        Sub Category
                    </p>
                    <p class=" text-gray-400 text-13px">
                        Pants
                    </p>
                </div>
                <div class="flex-none w-fit">
                    <p class=" text-gray-900 text-13px mb-1">
                        Product Size
                    </p>
                    <p class=" text-gray-400 text-13px capitalize">
                        16
                    </p>
                </div>
                <div class="flex-none w-fit">
                    <p class=" text-gray-900 text-13px mb-1">
                        Color
                    </p>
                    <p class=" text-gray-400 text-13px capitalize">
                        Black
                    </p>
                </div>
            </div>
            <div class="">
                    <hr class="my-2 h-0.5">
            </div>
            <!-- end row -->

            <div>
                    <p class="page-tittle text-sm pl-2">Order List</p>
            </div>
            

            <div>
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
                            <th class="px-6 py-2 text-xs text-gray-800 font-normal">
                                Buying Retail Price
                            </th>
                            <th class="px-6 py-2 text-xs text-gray-800 font-normal">
                                        
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
                            <td class="px-5 py-1.5">
                                <div class=" text-gray-500 text-table">
                                    1000
                                </div>
                            </td>
                            <td class="px-5 py-1.5 text-center">
                                <button type="button" class="btn-clear mr-3" title="Edit" id="edit-button">
                                    <i class="fal fa-pen fw300" style="color:#68728c;"></i>
                                </button>
                                <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                    <i class="fal fa-times fw300" style="color:#68728c;"></i>
                                </button>
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
                            <td class="px-5">
                            <div class=" text-gray-500 text-table">
                                    1000
                                </div>
                            </td>
                            <td class="px-5 py-1.5 text-center">
                                <button type="button" class="btn-clear mr-3" title="Edit" id="edit-button">
                                    <i class="fal fa-pen fw300" style="color:#68728c;"></i>
                                </button>
                                <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                    <i class="fal fa-times fw300" style="color:#68728c;"></i>
                                </button>
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
                            <td class="px-5 py-1.5">
                                <div class=" text-gray-500 text-table">
                                    A1
                                </div>
                            </td>
                            <td class="px-5 py-1.5 text-center">
                                <button type="button" class="btn-clear mr-3" title="Edit" id="edit-button">
                                    <i class="fal fa-pen fw300" style="color:#68728c;"></i>
                                </button>
                                <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                    <i class="fal fa-times fw300" style="color:#68728c;"></i>
                                </button>
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
                            <td class="px-5 py-1.5">
                                <div class=" text-gray-500 text-table">
                                    A1
                                </div>
                            </td>
                            <td class="px-5 py-1.5 text-center">
                                <button type="button" class="btn-clear mr-3" title="Edit" id="edit-button">
                                    <i class="fal fa-pen fw300" style="color:#68728c;"></i>
                                </button>
                                <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                    <i class="fal fa-times fw300" style="color:#68728c;"></i>
                                </button>
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
                            <td class="px-5 py-1.5">
                                <div class=" text-gray-500 text-table">
                                    A1
                                </div>
                            </td>
                            <td class="px-5 py-1.5 text-center">
                                <button type="button" class="btn-clear mr-3" title="Edit" id="edit-button">
                                    <i class="fal fa-pen fw300" style="color:#68728c;"></i>
                                </button>
                                <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                    <i class="fal fa-times fw300" style="color:#68728c;"></i>
                                </button>
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
                            <td class="px-5 py-1.5">
                                <div class=" text-gray-500 text-table">
                                    A1
                                </div>
                            </td>
                            <td class="px-5 py-1.5 text-center">
                                <button type="button" class="btn-clear mr-3" title="Edit" id="edit-button">
                                    <i class="fal fa-pen fw300" style="color:#68728c;"></i>
                                </button>
                                <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                    <i class="fal fa-times fw300" style="color:#68728c;"></i>
                                </button>
                            </td>
                        </tr>
                    
                    

                    </tbody>
                </table>
            </div>
            <div class="">
                    <hr class="my-2 h-0.5">
            </div>
            <div class="flex justify-end mb-3 pb-4">
                <div class="" style="margin-right:14%">
                    <p class="page-tittle text-sm pl-2 inline-block">Total Cost</p>

                    <p class="page-tittle font-semibold text-black text-sm pl-2 inline-block">110 MMks</p>
                </div>
            </div>
            <div class="flex justify-end pb-4">
                <button type="button" class="px-6 py-2.5 mr-5 rounded-sm
                        bg-black text-white font-medium text-xs leading-tight
                        hover:bg-black focus:bg-black focus:outline-none focus:ring-0
                        active:bg-black ">
                            Edit
                        </button>
            </div>

        </div>
        
        
    </div>



@endsection

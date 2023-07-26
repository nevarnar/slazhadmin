@extends('layouts.main')
@section('title', ' CreateOrUpdate Purchase Order')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Add Order Form</p>
        </div>
        <div class="pt-6 mb-6">
            <div class="grid grid-cols-9 gap-y-2 gap-x-8 mx-2">
                <div class="col-span-2">
                    <label for="" class="label-form">Invoice Number</label>
                </div>
                <div class="col-span-2">
                    <label for="" class="label-form">Supplier Name</label>
                </div>
                <div class="col-span-2">
                    <label for="" class="label-form">Date</label>
                </div>
                <div class="col-span-3">
                    <!-- free space for grid -->
                </div>

                <!-- start row -->
                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <input type="text" class="mt-2 input-form"
                               id="" placeholder="Invoice Number">
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <input type="text" class="input-form mt-2"
                               id="" placeholder="Supplier Name">
                    </div>
                </div><div class="col-span-2">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-2"
                               id="" placeholder="12 / 2 /2022">
                    </div>
                </div>
                <div class="col-span-3">
                     <!-- free space for grid  -->
                </div>
                <!-- end row -->

                <div class="col-span-9">
                    <label for="" class="label-form">Item Code</label>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <input type="text" class="form-control input-form mt-2"
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
                            <i class="fal fa-check" style="color:#68728c;"></i>
                        </a>
                    </button>
                    <button type="button" class="btn-clear" title="Error" id="error-button" data-bs-toggle="modal"
                        data-bs-target="#error_modal">
                        <i class="fal fa-times w-4" style="color:#68728c;"></i>
                    </button>
                </div>
            </div>

            <!-- start row -->
            <div class=" grid grid-cols-9 gap-y-2 gap-x-8 mx-2">
                <div class="col-span-2">
                    <label for="" class="label-form">Quantity</label>
                </div>
                <div class="col-span-2">
                    <label for="" class="label-form">Buying Price</label>
                </div>
                <div class="col-span-5">
                        <!-- free space for grid -->
                </div>


                <div class="col-span-2">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-2"
                               id="" placeholder="Quantity">
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-2"
                               id="" placeholder="Buying Price">
                    </div>
                </div>

                <div class="col-span-5">
                     <!-- free space for grid  -->
                </div>
            </div>
                <!-- end row -->



            <!-- start row -->

            <div class="flex w-3/5 mb-3">
                <table class="secondary-table overflow-hidden">
                    <thead class="secondary-table-thead">
                        <tr>
                            <th class="sec-thead-th">
                                Product Name
                            </th>
                            <th class="sec-thead-th">
                                Brand
                            </th>
                            <th class="sec-thead-th">
                                Sub Category
                            </th>
                            <th class="sec-thead-th">
                                Product Size
                            </th>
                            <th class="sec-thead-th">
                                Color
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="sec-table-td">
                                    Levis Pants
                            </td>
                            <td class="sec-table-td">
                                    Levis
                            </td>
                            <td class="sec-table-td">
                                    Pants
                            </td>
                            <td class="sec-table-td">
                                    16
                            </td>
                            <td class="sec-table-td">
                                <div class=" text-gray-500 text-table">
                                    Black
                                </div>
                            </td>

                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="">
                    <hr class="my-2 h-0.5">
            </div>
            <!-- end row -->

            <div>
                <p class="page-tittle text-sm pl-2 py-2">Order List</p>
            </div>


            <div>
                <table class="secondary-table overflow-hidden">
                    <thead class="secondary-table-thead">
                        <tr>
                            <th class="sec-thead-th">
                                Item Code
                            </th>
                            <th class="sec-thead-th">
                                Product Name
                            </th>
                            <th class="sec-thead-th">
                                Brand
                            </th>
                            <th class="sec-thead-th">
                                Sub Category
                            </th>
                            <th class="sec-thead-th">
                                Product Size
                            </th>
                            <th class="sec-thead-th">
                                Quantity
                            </th>
                            <th class="sec-thead-th">
                                Buying Retail Price
                            </th>
                            <th class="sec-thead-th">

                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="whitespace-nowrap">
                            <td class="sec-table-td">
                                    1001
                            </td>
                            <td class="sec-table-td">
                                    Levis Pants
                            </td>
                            <td class="sec-table-td">
                                    Levis
                            </td>
                            <td class="sec-table-td">
                                    Pants
                            </td>
                            <td class="sec-table-td">
                                    16
                            </td>
                            <td class="sec-table-td">
                                    10
                            </td>
                            <td class="sec-table-td">
                                    1000
                            </td>
                            <td class="sec-table-td">
                                <button type="button" class=" mr-3" title="Edit" id="edit-button">
                                    <i class="fal fa-pen"></i>
                                </button>
                                <button type="button" title="Delete" id="delete-button">
                                    <i class="fal fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="whitespace-nowrap">
                            <td class="sec-table-td">
                                    1001
                            </td>
                            <td class="sec-table-td">
                                    Levis Pants
                            </td>
                            <td class="sec-table-td">
                                    Levis
                            </td>
                            <td class="sec-table-td">
                                    Pants
                            </td>
                            <td class="sec-table-td">
                                    16
                            </td>
                            <td class="sec-table-td">
                                    10
                            </td>
                            <td class="sec-table-td">
                                    1000
                            </td>
                            <td class="sec-table-td">
                                <button type="button" class="mr-3" title="Edit" id="edit-button">
                                    <i class="fal fa-pen "></i>
                                </button>
                                <button type="button" title="Delete" id="delete-button">
                                    <i class="fal fa-times "></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="whitespace-nowrap">
                            <td class="sec-table-td">
                                    1001
                            </td>
                            <td class="sec-table-td">
                                    Levis Pants
                            </td>
                            <td class="sec-table-td">
                                    Levis
                            </td>
                            <td class="sec-table-td">
                                    Pants
                            </td>
                            <td class="sec-table-td">
                                    16
                            </td>
                            <td class="sec-table-td">
                                    10
                            </td>
                            <td class="sec-table-td">
                                    A1
                            </td>
                            <td class="sec-table-td">
                                <button type="button" class="mr-3" title="Edit" id="edit-button">
                                    <i class="fal fa-pen"></i>
                                </button>
                                <button type="button" title="Delete" id="delete-button">
                                    <i class="fal fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="whitespace-nowrap">
                            <td class="sec-table-td">
                                    1001
                            </td>
                            <td class="sec-table-td">
                                    Levis Pants
                            </td>
                            <td class="sec-table-td">
                                    Levis
                            </td>
                            <td class="sec-table-td">
                                    Pants
                            </td>
                            <td class="sec-table-td">
                                    16
                            </td>
                            <td class="sec-table-td">
                                    10
                            </td>
                            <td class="sec-table-td">
                                    A1
                            </td>
                            <td class="sec-table-td">
                                <button type="button" class=" mr-3" title="Edit" id="edit-button">
                                    <i class="fal fa-pen "></i>
                                </button>
                                <button type="button" class="" title="Delete" id="delete-button">
                                    <i class="fal fa-times "></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="whitespace-nowrap">
                            <td class="sec-table-td">
                                    1001
                            </td>
                            <td class="sec-table-td">
                                    Levis Pants
                            </td>
                            <td class="sec-table-td">
                                    Levis
                            </td>
                            <td class="sec-table-td">
                                    Pants
                            </td>
                            <td class="sec-table-td">
                                    16
                            </td>
                            <td class="sec-table-td">
                                    10
                            </td>
                            <td class="sec-table-td">
                                    A1
                            </td>
                            <td class="sec-table-td">
                                <button type="button" class=" mr-3" title="Edit" id="edit-button">
                                    <i class="fal fa-pen "></i>
                                </button>
                                <button type="button" class="" title="Delete" id="delete-button">
                                    <i class="fal fa-times "></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="whitespace-nowrap">
                            <td class="sec-table-td">
                                    1001
                            </td>
                            <td class="sec-table-td">
                                    Levis Pants
                            </td>
                            <td class="sec-table-td">
                                    Levis
                            </td>
                            <td class="sec-table-td">
                                    Pants
                            </td>
                            <td class="sec-table-td">
                                    16
                            </td>
                            <td class="sec-table-td">
                                    10
                            </td>
                            <td class="sec-table-td">
                                    A1
                            </td>
                            <td class="sec-table-td">
                                <button type="button" class="mr-3" title="Edit" id="edit-button">
                                    <i class="fal fa-pen"></i>
                                </button>
                                <button type="button" title="Delete" id="delete-button">
                                    <i class="fal fa-times"></i>
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
                <button type="button" class="primary-button bg-black">
                    Create
                </button>
            </div>

        </div>


    </div>



@endsection

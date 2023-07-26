@extends('layouts.main')
@section('title', ' Create Coupon')
@section('content')

<div class="inner-main-container">
        <div>
            <p class="page-tittle">
                Create Coupon
            </p>
        </div>
        <div class="pt-6 mb-6">
            <div class="grid grid-cols-7 gap-x-8 mx-2">
                <!-- start row -->
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Coupon Code</label
                    >
                </div>
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Quantity</label
                    >
                </div>
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Duration</label
                    >
                </div>
                <div class="col-span-1">
                    <!-- free space for grid -->
                </div>

                
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Coupon Code"
                        />
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-2">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Quantity"
                        />
                    </div>
                    <label class="checkbox-container">Based On Amount
                        <input type="checkbox" >
                        <span class="flashsale-check"></span>
                    </label>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Duration"
                        />
                    </div>
                    
                </div>
                <div class="col-span-1">
                    <!-- free space for grid  -->
                </div>
                <!-- end row -->

                <!-- start row -->
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Discount Type</label
                    >
                </div>
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Promotion Amount</label
                    >
                </div>
                <div class="col-span-3">
                </div>

                
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <select
                            name=""
                            class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-2"
                            id=""
                            placeholder="S/M/L"
                        >
                            <option value="" disabled selected>Fixed Discount</option>
                            <option value="1">Small</option>
                            <option value="1">Medium</option>
                            <option value="1">Large</option>
                        </select>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Promotion Amount"
                        />
                    </div>
                </div>

                <div class="col-span-3">
                    <!-- free space for grid  -->
                </div>
                <!-- end row -->

                <!-- start row -->
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <label for="" class="form-label label-form"
                        >Total Minimum Purchase Amount</label
                    >
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <select
                            name=""
                            class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-2"
                            id=""
                            placeholder="S/M/L"
                        >
                            <option value="" disabled selected>Yes</option>
                            <option value="1">Small</option>
                            <option value="1">Medium</option>
                            <option value="1">Large</option>
                        </select>
                    </div>
                </div>

                <div class="col-span-3">
                    <!-- free space for grid  -->
                </div>
                <!-- end row -->

                
                <!-- start row -->
                <div class="col-span-7">
                    <label for="" class="form-label label-form mb-2"
                        >Minimum Purchase Amount</label
                    >
                </div>
                <div class="col-span-4 mb-6">
                    <div class="form-group mb-2 w-1/2 pr-4">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder=""
                        />
                    </div>
                    <label class="checkbox-container">Customer should be picked same categories & items
                        <input type="checkbox" >
                        <span class="flashsale-check"></span>
                    </label>
                </div>
                <div class="col-span-3">
                    <!-- free space for grid  -->
                </div>
                <!-- end row -->

                <!-- start row -->
                <div class="col-span-7">
                    <label for="" class="form-label label-form mb-2"
                        >Description</label
                    >
                </div>
                <div class="col-span-7">
                    <textarea name=""
                        class="mt-2 min-h-[160px] focus:outline-none rounded animated-textarea active:shadow-none active:outline-none block"
                        cols="30"
                        rows="10"
                        style="border: 1px solid #e5e7eb"
                        ></textarea>
                </div>



                
                <!-- end row -->




                <div class="col-span-7 mt-3 mb-2">
                    <p class="page-tittle">
                        Add SKU
                    </p>
                </div>


                <!-- start row -->
                <div class="col-span-7">
                    <label for="" class="form-label label-form"
                        >Promotion Type</label
                    >
                </div>

                
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <select
                            name=""
                            class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-2"
                            id=""
                            placeholder="S/M/L"
                        >
                            <option value="" disabled selected>Bulk Action</option>
                            <option value="1">Small</option>
                            <option value="1">Medium</option>
                            <option value="1">Large</option>
                        </select>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Township"
                        />
                    </div>
                </div>

                <div class="col-span-3">
                    <button class="primary-button btn-clear mt-2">
                        Add 
                    </button>
                    <!-- free space for grid  -->
                </div>
                <!-- end row -->
                <div class="col-span-7">
                    <hr class="my-2 h-0.5" />
                </div>
            </div>


            <div class="w-full pt-2 mb-6">
                <table class="secondary-table">
                    <thead class="secondary-table-thead">
                        <tr>
                            <th class="sec-thead-th"></th>
                            <th class="sec-thead-th">Product Name</th>
                            <th class="sec-thead-th">Item Code</th>
                            <th class="sec-thead-th">Brand</th>
                            <th class="sec-thead-th">Product Category</th>
                            <th class="sec-thead-th">Type</th>
                            <th class="sec-thead-th"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="sec-table-td">1</td>
                            <td class="sec-table-td">
                                H&M-A101
                            </td>
                            <td class="sec-table-td">
                                A101
                            </td>
                            <td class="sec-table-td">
                                H&M
                            </td>
                            <td class="sec-table-td">
                                Pants
                            </td>
                            <td class="sec-table-td">
                                Sub Product
                            </td>
                            <td class="sec-table-td">
                                 <button
                                    type="button"
                                    title="Delete"
                                    id="delete_button"
                                >
                                    <a class="a-clear" href="#">
                                        <i class="fal fa-trash"></i>
                                    </a>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end pb-4">
                <button
                    type="button"
                    class="primary-button bg-black"
                >
                    create
                </button>
            </div>
        </div>
    </div>



@endsection

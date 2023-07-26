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
            <div class="grid grid-cols-8 gap-x-8 mx-2">
                <!-- start row -->
                <div class="col-span-4">
                    <label for="" class="form-label label-form"
                        >Coupon Name</label
                    >
                </div>
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Coupon Code</label
                    >
                </div>
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Duration</label
                    >
                </div>

                
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="In English"
                        />
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="In Myanmar"
                        />
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-2">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Code"
                        />
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Duration"
                        />
                        <!-- start-end date picker -->
                    </div>
                </div>
                <!-- end row -->

                <!-- start row -->
                <div class="col-span-8">
                    <label for="" class="form-label label-form"
                        >Description</label
                    >
                </div>
                <div class="col-span-6 mb-3">
                    <textarea name=""
                        class="mt-2 w-full min-h-[160px] focus:outline-none rounded animated-textarea active:shadow-none active:outline-none block"
                        cols="30"
                        rows="10"
                        style="border: 1px solid #e5e7eb"
                        ></textarea>
                </div><div class="col-span-2"></div>
                <div class="col-span-6 mb-4">
                    <textarea name=""
                        class="mt-2 w-full min-h-[160px] focus:outline-none rounded animated-textarea active:shadow-none active:outline-none block"
                        cols="30"
                        rows="10"
                        style="border: 1px solid #e5e7eb"
                        ></textarea>
                </div><div class="col-span-2"></div>
                <!-- end row -->

                <!-- start row -->
                <div class="col-span-8">
                    <label for="" class="form-label label-form"
                        >Upload Image</label
                    >
                </div>
                <div class=" col-span-4 mb-4">
                    <input type="file" class="form-control input-form mt-3"
                        placeholder=""/>
                </div><div class=" col-span-4"></div>
                <!-- end row -->


                <!-- start row -->
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Coupon Discount Type</label
                    >
                </div>
                <div class="col-span-2">
                    <label for="" class="form-label label-form"
                        >Amount</label
                    >
                </div>
                <div class="col-span-4"></div>

                
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <select
                            name=""
                            class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-2"
                            id=""
                            placeholder="S/M/L"
                        >
                            <option value="" disabled selected>Percentage</option>
                        </select>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Amount"
                        />
                    </div>
                </div>

                <div class="col-span-4">
                    <!-- free space for grid  -->
                </div>
                <div class=" col-span-8">
                    <hr class="my-2 h-0.5" />
                </div>
                <!-- end row -->

                <!-- start row -->
                    <div class=" col-span-8 px-3 mb-4">
                        <p class="text-xs primary-font text-gray-500">
                            Coupon Type is the limitation of products coupon can be used for. If you choose every item,the discount will be affected on every items & if you choose limited,coupons can be used only for that chosen categories / brands.If you choose campaign,the coupon can only be used in chosen campaign.
                        </p>
                    </div>
                <div class=" col-span-8">
                    <label for="" class="form-label label-form"
                        >Coupon Type</label
                    >
                </div>   
                <div class=" col-span-2 mb-4">
                    <select name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-2"
                            id=""
                            placeholder="Public"
                        >
                            <option value="public" selected>Public</option>
                            <option value="private">Private</option>
                            <option value="limited">Limited</option>
                    </select>
                </div>   <div class=" col-span-6"></div>
                <div class=" col-span-8">
                    <hr class="my-2 h-0.5" />
                </div>
                <!-- end row -->

                <!-- start row -->
                <div class=" col-span-8">
                    <label for="" class="form-label label-form"
                        >Coupon Limitation</label
                    >
                </div>   
                <div class=" col-span-2 mb-4">
                    <select name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-2"
                            id=""
                            placeholder="Public"
                        >
                            <option value="" selected>Specific</option>
                            <option value="1">Spe</option>
                            <option value="1">Ci</option>
                            <option value="1">Fic</option>
                    </select>
                </div> <div class=" col-span-6"></div>
                <div class=" col-span-2">
                    <label for="" class="form-label label-form"
                        >Coupon Limitation</label
                    >
                </div>   
                <div class=" col-span-2">
                    <label for="" class="form-label label-form"
                        >Name</label
                    >
                </div>  <div class="col-span-4"></div>

                <div class=" col-span-2">
                    <select name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-2"
                            id=""
                            placeholder="Public"
                        >
                            <option value="" selected>Specific</option>
                            <option value="1">Small</option>
                            <option value="1">Medium</option>
                            <option value="1">Large</option>
                    </select>
                </div> 
                <div class="col-span-2">
                    <div class="form-group mb-2">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Name"
                        />
                    </div>
                </div><div class=" col-span-4"></div>

                <div class=" col-span-8 w-full pt-2 mb-6">
                    <table class="secondary-table">
                        <thead class="secondary-table-thead">
                            <tr>
                                <th class="sec-thead-th">Name</th>
                                <th class="sec-thead-th">Type</th>
                                <th class="sec-thead-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sec-table-td">
                                    H&M-A101
                                </td>
                                <td class="sec-table-td">
                                    Brand
                                </td>
                                <td class="sec-table-td">
                                    <button class="primary-font text-sm text-gray-400"
                                        type="button"
                                        title="Delete"
                                        id="delete_button"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class=" col-span-8">
                    <hr class="my-2 h-0.5" />
                </div>
                <!-- end row -->


                <!-- start row -->
                <div class=" col-span-4"></div>
                <div class=" col-span-2">
                    <label for="" class="form-label label-form"
                        >Amount</label
                    >
                </div> <div class=" col-span-2"></div> 
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

                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Amount"
                        />
                    </div>
                </div><div class=" col-span-2"></div>
                <!-- end row -->

                <div class=" col-span-8">
                    <label for="" class="form-label label-form"
                        >Limitation</label
                    >
                </div>   
                <div class=" col-span-2 mb-4">
                    <select name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-2"
                            id=""
                            placeholder="Public"
                        >
                            <option value="" selected>Public</option>
                            <option value="1">Small</option>
                            <option value="1">Medium</option>
                            <option value="1">Large</option>
                    </select>
                </div>   <div class=" col-span-6"></div>

                <div class=" col-span-2">
                    <label for="" class="form-label label-form"
                        >Coupon Limitation</label
                    >
                </div>   
                <div class=" col-span-2">
                    <label for="" class="form-label label-form"
                        >Name</label
                    >
                </div>  <div class="col-span-4"></div>

                <div class=" col-span-2">
                    <select name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-2"
                            id=""
                            placeholder="Public"
                        >
                            <option value="" selected>Specific</option>
                            <option value="1">Small</option>
                            <option value="1">Medium</option>
                            <option value="1">Large</option>
                    </select>
                </div> 
                <div class="col-span-2">
                    <div class="form-group mb-2">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Name"
                        />
                    </div>
                </div>
                <div class="col-span-2">
                    <button class="primary-button btn-clear mt-2">
                        Add 
                    </button>
                </div><div class="col-span-2"></div>

                <div class=" col-span-8 w-full pt-2 mb-6">
                    <table class="secondary-table">
                        <thead class="secondary-table-thead">
                            <tr>
                                <th class="sec-thead-th">Name</th>
                                <th class="sec-thead-th">Type</th>
                                <th class="sec-thead-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sec-table-td">
                                    H&M-A101
                                </td>
                                <td class="sec-table-td">
                                    Brand
                                </td>
                                <td class="sec-table-td">
                                    <button class="primary-font text-sm text-gray-400"
                                        type="button"
                                        title="Delete"
                                        id="delete_button"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                
                
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

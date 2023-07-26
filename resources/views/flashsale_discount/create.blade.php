@extends('layouts.main')
@section('title', ' Create Discount')
@section('content')


    {{-- <div class="inner-main-container">
    <div>
        <p class="page-tittle">Create Flashsale Discount</p>
    </div>
    <div class="pt-6 mb-6">
      <div class="grid grid-cols-7 gap-x-8 mx-2">
        <!-- start row -->
        <div class="col-span-2">
            <label for="" class="form-label label-form">Duration</label>
        </div>
        <div class="col-span-2">
            <label for="" class="form-label label-form">Start Time</label>
        </div>
        <div class="col-span-2">
            <label for="" class="form-label label-form">End Time</label>
        </div>
        <div class="col-span-1">
          <!-- free space for grid -->
        </div>

        <div class="col-span-2 mb-3">
          <div class="form-group mb-2 mt-2">
                <input type="text" class="form-control input-form mt-2" placeholder="Duration">
                <p class="text-red-600 text-xs"></p>
          </div>
        </div>
        <div class="col-span-2 mb-3">
            <div class="form-group mb-2 mt-2">
                <input type="text" class="form-control input-form mt-2" placeholder="Start Time">
                <p class="text-red-600 text-xs"></p>
            </div>


        </div>
        <div class="col-span-2 mb-3">
            <div class="form-group mb-2 mt-2">
                <input type="text" class="form-control input-form mt-2" placeholder="End Time">
                <p class="text-red-600 text-xs"></p>
            </div>
        </div>
        <div class="col-span-1">
            <!-- free space for grid -->
        </div>
        <!-- end row -->

        <!-- start row -->
        <div class="col-span-2">
            <label for="" class="form-label label-form">Discount Type</label>
        </div>

        <div class="col-span-2">
            <label for="" class="form-label label-form">Minimum Purchase Amount</label>
        </div>

        <div class="col-span-3"></div>

        <div class="col-span-2 mb-3">
                <div class="form-group mb-2 mt-2">
                    <select name="" id="" class="text-sm primary-font px-3 py-2 w-full">
                        <option value="1">1</option>
                    </select>
                    <p class="text-red-600 text-xs"></p>
                </div>
            </div>

        <div class="col-span-2 mb-3">
            <div class="form-group mb-2">
                <input
                type="number"
                class="form-control input-form mt-2"
                id=""
                placeholder="Promotion Amount"
                />
                <p class="text-red-600 text-xs"></p>
            </div>
            <label class="checkbox-container w-4 h-4"
                >
                <input type="checkbox"/>
                <span class="flashsale-check"></span>
            </label>
        </div>
        <div class="col-span-3"></div>
        <!-- end row -->



        <!-- Add sku -->
            <div class="col-span-7 mt-3 mb-2">
                <p class="page-tittle">Add SKU</p>
            </div>

            <!-- start row -->
            <div class="col-span-2">
                <label for="" class="form-label label-form">Product Type</label>
            </div>
            <div class="col-span-2">
                <label for="" class="form-label label-form">Limited Quantity</label>
            </div>
            <div class="col-span-3"></div>

            <div class="col-span-2 mb-3">
                <div class="form-group mb-2 mt-2">
                    <select name="" id="" class="text-sm primary-font px-3 py-2 w-full">
                        <option value="1">1</option>
                    </select>
                    <p class="text-red-600 text-xs"></p>
                </div>
            </div>
            <div class="col-span-2 mb-3">
                <div class="form-group mb-2">
                    <input
                    type="number"
                    class="form-control input-form mt-2"
                    id="" disabled
                    placeholder="Limited Quantity"
                    />
                    <p class="text-red-600 text-xs"></p>
                </div>
                <label class="checkbox-container w-4 h-4"
                    >
                    <input type="checkbox"/>
                    <span class="flashsale-check"></span>
                </label>
            </div>
            <div class="col-span-3"></div>

            <!-- end row -->

            <!-- start row -->
            <div class="col-span-2">
                <label for="" class="form-label label-form">Maximum Amount Per User</label>
            </div>
            <div class="col-span-2">
                <label for="" class="form-label label-form">Discount Amount</label>
            </div>
            <div class="col-span-3"></div>

            <div class="col-span-2 mb-3">
                <div class="form-group mb-2">
                    <input
                    type="number"
                    class="form-control input-form mt-2"
                    id="" disabled
                    placeholder="Max Amount"
                    />
                    <p class="text-red-600 text-xs"></p>
                </div>
                <label class="checkbox-container w-4 h-4"
                    >Unlimited
                    <input type="checkbox"/>
                    <span class="flashsale-check"></span>
                </label>
            </div>
            <div class="col-span-2 mb-3">
                <div class="form-group mb-2">
                    <input
                    type="number"
                    class="form-control input-form mt-2"
                    id="" disabled
                    placeholder="Discount Amount"
                    />
                    <p class="text-red-600 text-xs"></p>
                </div>

            </div>
            <div class="col-span-3">
                <button class="primary-button btn-clear mt-2">
                Add
                </button>
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
                    <th class="sec-thead-th">Name</th>
                    <th class="sec-thead-th">Item Code</th>
                    <th class="sec-thead-th">Brand</th>
                    <th class="sec-thead-th">Product Category</th>
                    <th class="sec-thead-th">Type</th>
                    <th class="sec-thead-th"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="sec-table-td">
                        H&M101A
                    </td>
                    <td class="sec-table-td">
                        A-101
                    </td>
                    <td class="sec-table-td">
                        H&M
                    </td>
                    <td class="sec-table-td">
                        Pants
                    </td>
                    <td class="sec-table-td">
                        Sub Products
                    </td>
                    <td class="sec-table-td">
                        <button
                        type="button"
                        title="Delete"
                        id="delete-button"
                        data-bs-toggle="modal" data-bs-target="#delete_modal"
                        >
                            <a href="#">
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
                Create
            </button>
      </div>
    </div>

    <!-- modal -->
    <div
      ref="modal"
      class="modal fade primary-modal"
      id="delete_modal"
      tabindex="-1"
      aria-labelledby="createModalLabel"
      aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered modal-box">
            <div class="modal-content content-modal" style="width: auto">
                <div class="modal-header border-b-0 mx-2">
                    <p class="pt-8 px-8 text-black primary-font text-lg font-semibold">
                    Warning!
                    </p>
                </div>
                <form>
                    <div class="modal-body px-2 mx-2">
                        <div class="block p-6 pt-3 rounded-lg bg-white">
                            <div class="mb-4">
                                <p class="text-sm primary-font">
                                    These products are different from other products in
                                    promotion details. Are you sure to continue
                                </p>
                            </div>
                            <div class="mb-3 pb-2 border-b">
                                <div class="form-check inline-block ml-3 mr-2">
                                    <input
                                    class="form-check-input input-check mt-1 float-center"
                                    type="checkbox"
                                    value=""
                                    />
                                </div>
                                <div class="inline-block">
                                    <button
                                    class="btn-clear text-sm primary-font"
                                    type="button"
                                    >
                                    Delete
                                    </button>
                                </div>
                            </div>
                            <div>
                                <table class="primary-table">
                                    <tbody>
                                        <tr style="border: none">
                                            <td style="padding-left: 0">
                                                <div class="form-check inline-block ml-3 mr-2">
                                                    <input
                                                    class="
                                                        form-check-input
                                                        input-check
                                                        my-0
                                                        float-center
                                                    "
                                                    type="checkbox"
                                                    value=""
                                                    />
                                                </div>
                                                <span >
                                                    1
                                                </span>
                                            </td>
                                            <td>
                                                H&M101A
                                            </td>
                                            <td>
                                                A-101
                                            </td>
                                            <td>hm</td>
                                            <td>
                                                Pants
                                            </td>
                                            <td>Sub Products</td>
                                            <td>
                                            <button
                                                type="button"
                                                title="Delete"
                                                class=""
                                            >
                                                <i class="fal fa-trash-alt"></i>
                                            </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer modal-btn-container">
                        <button
                            type="button"
                            class="primary-button bg-black"
                            data-bs-dismiss="modal"
                        >
                            Confirm
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div> --}}

    <flash-sale-create-edit isediting="{{ $isediting }}" />


@endsection

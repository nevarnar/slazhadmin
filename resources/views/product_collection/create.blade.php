@extends('layouts.main')
@section('title', 'Product Collection')
@section('content')

    <div class="inner-main-container">
        <div>
            <div>

                <div>
                    <p class="page-tittle">
                        Create Product Collection
                    </p>
                </div>
                
                <div class="pt-6 mb-6">
                    <div class="grid grid-cols-8 gap-y-2 gap-x-8 mx-2">
                        <div class="col-span-2">
                            <label for="" class="label-form">Product Collection</label>
                        </div>
                        <div class="col-span-2">
                            <label for="" class="label-form">&nbsp;</label>
                        </div>
                        <div class="col-span-2">
                            <label for="" class="label-form"
                                >Product Collection Item Code</label
                            >
                        </div>
                        <div class="col-span-2">
                            <!-- free space for grid -->
                        </div>

                        <!-- start row -->
                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <input
                                    type="text"
                                    class="form-control input-form mt-3"
                                    placeholder="In English"
                                />
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <input
                                    type="text"
                                    class="form-control input-form mt-3"
                                    id=""
                                    placeholder="In Myanmar"
                                />
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <input
                                    type="text"
                                    class="mt-3 input-form"
                                    placeholder=""
                                />
                                
                            </div>
                        </div>
                        <div class="col-span-2">
                            <!-- free space for grid  -->
                        </div>

                        <div class="col-span-8">
                            <hr class="my-2 h-0.5" />
                        </div>
                        <!-- end row -->

                        <!-- start row -->
                        <div class="col-span-2">
                            <label for="brand" class="label-form"
                                >Brand </label
                            >
                        </div>
                        <div class="col-span-2">
                            <label for="gender" class="label-form"
                                >Gender</label
                            >
                        </div>

                        <div class="col-span-2">
                            <label for="tag" class="label-form">Tag</label>
                        </div>
                        <div class="col-span-2">
                            <label for="category" class="label-form">Category</label>
                        </div>


                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <input
                                    type="text"
                                    class="mt-3 input-form"
                                    placeholder="LV"
                                />
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <input
                                    type="text"
                                    class="mt-3 input-form"
                                    placeholder="Male"
                                />
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <input
                                    type="text"
                                    class="mt-3 input-form"
                                    placeholder="Beach"
                                />
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="form-group inline-block mb-4">
                                <input
                                    type="text"
                                    class="mt-3 input-form"
                                    placeholder="Category"
                                />
                                
                            </div>
                            <button
                                class="inline-block"
                                title="Add Tag"
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#add_tag"
                                data-toggle="modal"
                            >
                                <i
                                    class="fal fa-plus text-gray-700 pl-3 py-2"
                                ></i>
                            </button>
                        </div>
                        <!-- <div class="col-span-2">
                            
                        </div> -->

                        <!-- end row -->

                        <!-- start row -->
                        <div class="col-span-2">
                            <label for="season" class="label-form"
                                >Seasons</label
                            >
                        </div>
                        <div class="col-span-2">
                            <label for="occassion" class="label-form"
                                >Occassions</label
                            >
                        </div>
                        <div class="col-span-2">
                            <label for="Color" class="label-form">Color</label>
                        </div>
                        <div class="col-span-2">
                            
                        </div>

                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <input
                                    type="text"
                                    class="mt-3 input-form"
                                    placeholder="Summer"
                                />
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <input
                                    type="text"
                                    class="mt-3 input-form"
                                    placeholder="Officer Wear"
                                />
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <input
                                    type="text"
                                    class="mt-3 input-form"
                                    placeholder="Yellow"
                                />
                                
                            </div>
                           
                        </div>
                        <div class="col-span-2">
                            <!--  -->
                        </div>
                        <div class="col-span-8">
                            <hr class="my-2 h-0.5" />
                        </div>
                        <!-- end row -->
                       

                        <!-- start row -->
                        <div class="col-span-8">
                            <div class="form-group mb-6">
                                <label
                                    for=""
                                    class="form-label block label-form mb-3"
                                >
                                    Product Collection Description
                                </label>
                                <textarea
                                    name=""
                                    class="form-textarea text-table text-left animated-textarea"
                                    id=""
                                    cols="30"
                                    rows="7"
                                    style="border: 1px solid #e5e7eb"
                                    placeholder="In English"
                                ></textarea>
                            </div>
                        </div>
                        <div class="col-span-8">
                            <div class="form-group mb-6">
                                <textarea
                                    name=""
                                    class="form-textarea text-table text-left animated-textarea"
                                    id=""
                                    cols="30"
                                    rows="7"
                                    style="border: 1px solid #e5e7eb"
                                    placeholder="In Myanmar"
                                ></textarea>
                            </div>
                        </div>
                        <div class="col-span-8">
                            <hr class="my-2 h-0.5" />
                        </div>
                        <!-- end row -->

                        
                        <div class="col-span-6">
                            <div class="form-group mb-4">
                                <label for="" class="form-label label-form">
                                    Product Collection Gallery (  3 Photos  )
                                </label>
                                <input
                                    multiple
                                    type="file"
                                    class="form-control input-form mt-3"
                                    placeholder=""
                                    ref="formGallaryImgs"
                                />
                                <p
                                    class="text-validation "
                                >
                                    Product Collection Gallary need 3 to 5 photos
                                </p>
                                <div class="mt-3 flex flex-nowrap">
                                    <div
                                        class="mt-3 file-name-box"
                                        
                                    >
                                        <button
                                            class="cancel-btn"
                                            
                                        >
                                            X
                                        </button>
                                        <p class="text-table">
                                             gallary name 
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-2"></div>
                    </div>
                </div>
            </div>


            <div>
                <div class="pt-6 mb-6">
                    <div class="grid grid-cols-8 gap-y-2 gap-x-8 mx-2">

                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <input
                                type="text"
                                class="mt-2 input-form"
                                id="product"
                                placeholder="Sub Product"
                            />
                            </div>
                        </div>
                        <div class="col-span-4">
                            <button class="primary-button mt-2">
                                Add
                            </button>
                        </div> <div class="col-span-2"></div>

                        <div class="col-span-8">
                            <hr class="my-2 h-0.5" />
                        </div>
                        <!-- end row -->
                    </div>

                <div class="my-4">
                    <table class="secondary-table overflow-hidden">
                        <thead class="secondary-table-thead">
                            <tr>
                                <th class="sec-thead-th"></th>
                                <th class="sec-thead-th">Product Name</th>
                                <th class="sec-thead-th">
                                    Product Sub Category
                                </th>
                                <th class="sec-thead-th">Brand</th>
                                <th class="sec-thead-th">Color</th>
                                <th class="sec-thead-th">Sizes</th>
                                <th class="sec-thead-th">Price</th>
                                <th class="sec-thead-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sec-table-td">1</td>
                                <td class="sec-table-td">
                                    product name
                                </td>
                                <td class="sec-table-td">
                                        product sub_categories
                                </td>
                                <td class="sec-table-td">
                                    brands
                                </td>
                                <td class="sec-table-td">
                                    Red
                                </td>
                                <td class="sec-table-td">
                                    1,2,3,4,5
                                </td>
                                <td class="sec-table-td">
                                    1000
                                </td>
                                <td class="px-5 py-1.5 text-center">
                                    <button
                                        type="button"
                                        class="btn-clear"
                                        title="Delete"
                                        id="delete-button"
                                    >
                                        <i
                                            class="fal fa-trash"
                                            style="color: #68728c"
                                        ></i>
                                    </button>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>

                    <div class="w-full">
                        <hr class="my-2 h-0.5" />
                    </div>
                    <div class="flex justify-end mr-12 mt-3">
                        <p class="font-semibold text-sm inline-block">
                            Style Price
                        </p>
                        <p class="font-normal text-sm inline-block ml-4">
                            2000 (Min)
                        </p>
                    </div>
                </div>

            <div class="flex justify-end mb-8">
                <button
                    type="button"
                    title="Create"
                    class="primary-button bg-black"
                >
                    Create
                </button>
            </div>
        </div>
    </div>



        </div>

        <div
            class="modal fade primary-modal"
            id="add_category"
            tabindex="-1"
            aria-labelledby="createModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-box">
                <div class="modal-content content-modal">
                    <div class="modal-header border-b-0 mx-2">
                        <p class="pt-8 px-8 text-base">Create Style Category</p>
                    </div>
                    <div class="modal-body px-2 mx-2">
                        <form>
                            <div class="block p-6 rounded-lg bg-white">
                                <div class="form-group">
                                    <label
                                        for="Name"
                                        class="form-label label-form"
                                        >Name (In English)</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control input-form mt-3"
                                        id="Name"
                                        placeholder=""
                                    />
                                </div>
                                <div class="form-group">
                                    <label
                                        for="mmName"
                                        class="form-label label-form"
                                        >Name (In Myanmar)</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control input-form mt-3"
                                        id="mmName"
                                        placeholder=""
                                    />
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer modal-btn-container">
                        <button
                            type="button"
                            class="primary-button bg-black"
                            data-bs-dismiss="modal"
                        >
                            Add
                        </button>
                        <button
                            type="button"
                            class="btn btn-light cancel"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal fade primary-modal"
            id="add_tag"
            tabindex="-1"
            aria-labelledby="createModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered modal-box">
                <div class="modal-content content-modal">
                    <div class="modal-header border-b-0 mx-2">
                        <p class="pt-8 px-8 text-base">Create Tag</p>
                    </div>
                    <div class="modal-body px-2 mx-2">
                        <form>
                            <div class="block p-6 rounded-lg bg-white">
                                <div class="form-group">
                                    <label
                                        for="Name"
                                        class="form-label label-form"
                                        >Name</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control input-form mt-3"
                                        id="Name"
                                        placeholder=""
                                    />
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer modal-btn-container">
                        <button
                            type="button"
                            class="primary-button bg-black"
                            data-bs-dismiss="modal"
                        >
                            Add
                        </button>
                        <button
                            id="cancel"
                            type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.main')
@section('title', 'CreateOrUpdate Dekivery Man')
@section('content')

    {{-- <div class="inner-main-container">
        <div>
            <div>

                <div>
                    <p class="page-tittle">
                        CreateOrUpdate Delivery Man
                    </p>
                </div>

                <div class="pt-6 mb-6">
                    <div class="grid grid-cols-8 gap-y-0 gap-x-8 mx-2">
                        <div class="md:col-span-3 col-span-8 mb-4">
                            <label for="" class="label-form">Delivery Man Name (In English)</label>
                            <div class="form-group mb-2">
                                <input
                                    type="text"
                                    class="form-control input-form mt-2"
                                    placeholder="In English"
                                />
                            </div>
                            <p class="text-validation whitespace-nowrap">
                                Name is needed!
                            </p>
                        </div>

                        <div class="col-span-3">
                            <label for="" class="label-form">Delivery Man Name (In Myanmar)</label>
                            <div class="form-group mb-2">
                                <input
                                    type="text"
                                    class="form-control input-form mt-2"
                                    placeholder="In Myanmar"
                                />
                            </div>

                            <p class="text-validation whitespace-nowrap">
                                Name is needed!
                            </p>
                        </div>
                        <div class="col-span-2">
                            <!-- free space for grid -->
                        </div>


                        <!-- start row -->
                        <div class="col-span-3">
                            <label for="link" class="label-form"
                                >Phone Number </label>
                            <div class="form-group mb-4">
                                <input
                                    type="number"
                                    class="mt-2 input-form"
                                    placeholder="Phone Number"
                                />
                            </div>
                        </div>
                        <div class="col-span-5"></div>



                        <!-- end row -->


                        <!-- start row -->
                        <div class="col-span-3 mb-4">
                            <label for="link" class="label-form"
                                >Delivery Name </label
                            >
                            <div>
                                <div class="form-group block mb-2 relative">
                                    <input
                                        type="text"
                                        class="form-control input-form mt-3"
                                        id=""
                                        placeholder="In Myanmar"
                                    />
                                    <button
                                    class="absolute top-0 -right-8"
                                    title="Add Delivery Name"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#add_delivery"
                                    data-toggle="modal"
                                >
                                    <i
                                        class="fal fa-plus text-gray-700 pl-3 py-2"
                                    ></i>
                                </button>
                                </div>


                            </div>
                        </div>



                        <div class="col-span-5">

                        </div>
                        <!-- end row -->
                    </div>

                    <div class="flex justify-start mb-8 ml-2">
                        <button
                            type="button"
                            title="CreateOrUpdate"
                            class="primary-button bg-black"
                        >
                            CreateOrUpdate
                        </button>
                    </div>
                </div>
            </div>



        </div>





        <div class="modal fade primary-modal" id="add_delivery" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-box">
                <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                    <form>
                            <div class="modal-header border-b-0">
                                <p class="pt-8 px-8 text-base">
                                    Add New Delivery
                                </p>
                            </div>
                            <div class="modal-body px-2">
                                <div
                                    class="block p-6 rounded-lg bg-white"
                                >
                                    <div class="form-group mb-6">
                                        <label
                                            for="name"
                                            class="form-label label-form"
                                            >Delvery Name</label
                                        >
                                        <input
                                            type="text" autocomplete="off"
                                            class="form-control input-form mt-2"
                                            id="name"
                                            placeholder="Delivery Name"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-start px-8 pt-0 pb-8">
                                <button
                                    type="button"
                                    class="primary-button bg-black"
                                >
                                    CreateOrUpdate
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-light"
                                    data-bs-dismiss="modal"
                                    id="cancel"
                                >
                                    Cancel
                                </button>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <delivery-create-edit isediting='create'/>

@endsection

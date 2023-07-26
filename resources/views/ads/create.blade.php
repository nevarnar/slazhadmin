@extends('layouts.main')
@section('title', 'CreateOrUpdate Ads')
@section('content')

<ads-create-edit isediting='create'/>

                <div>
                    <p class="page-tittle">
                        Create Ads
                    </p>
                </div>

                <div class="pt-6 mb-6">
                    <div class="grid grid-cols-7 gap-y-0 gap-x-8 mx-2">
                        <div class="col-span-2">
                            <label for="" class="label-form">Ads Name</label>
                        </div>
                        <div class="col-span-2">
                            <label for="" class="label-form">Ads Type</label>
                        </div>
                        <div class="col-span-3">
                            <!-- free space for grid -->
                        </div>

                        <!-- start row -->
                        <div class="col-span-2 mb-4">
                            <div class="form-group mb-2">
                                <input
                                    type="text"
                                    class="form-control input-form mt-3"
                                    placeholder="Ads Name"
                                />
                            </div>

                            <p class="text-validation whitespace-nowrap">
                                Ads Name is needed!
                            </p>
                        </div>
                        <div class="col-span-3 mb-4">
                            <div>
                                <div class="form-group inline-block mb-2">
                                <input
                                    type="text"
                                    class="form-control input-form mt-3"
                                    id=""
                                    placeholder="Ads Type"
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
                            <p class="text-validation whitespace-nowrap">
                                Ads type is needed!
                            </p>
                        </div>
                        <div class="col-span-2 mb-4">
                            <!-- free space for grid  -->
                        </div>
                        <!-- end row -->

                        <!-- start row -->
                        <div class="col-span-7">
                            <label for="link" class="label-form"
                                >Link </label
                            >
                        </div>


                        <div class="col-span-4 mb-4">
                            <div class="form-group mb-4">
                                <input
                                    type="text"
                                    class="mt-3 input-form"
                                    placeholder="URL"
                                />
                            </div>
                        </div>
                        <div class="col-span-3">

                        </div>
                        <!-- end row -->

                        <div class="col-span-2">
                            <div class="form-group mb-4">
                                <label for="" class="form-label label-form">
                                    Upload Image
                                </label>
                                <input
                                    type="file"
                                    class="form-control input-form mt-3"
                                    placeholder=""
                                    ref="formGallaryImgs"
                                />
                                <p
                                    class="text-validation whitespace-nowrap"
                                >
                                    need photo
                                </p>

                            </div>
                        </div>
                        <div class="col-span-5"></div>
                    </div>

                    <div class="flex justify-start mb-8 ml-2">
                        <button
                            type="button"
                            title="Create"
                            class="primary-button bg-black"
                        >
                            Create
                        </button>
                    </div>
                </div>

@endsection

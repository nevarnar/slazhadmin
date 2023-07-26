@extends('layouts.main')
@section('title', ' Related Color')
@section('content')
    

<div class="inner-main-container">
    <div>
        <p class="page-tittle">Color</p>
    </div>
    <div class="relative flex justify-between">
        <div>
            <SearchBox pagination-url="categories?" :mutationName="mutationName" />
        </div>

        <button type="button" title="Create" id="create-button" 
            class="pr-1" data-bs-toggle="modal"
                            data-bs-target="#create_modal"
                            data-toggle="modal">
                            <i class="far fa-plus-square"></i>
                        </button>
    </div>
    <div class="block">
        <table class="primary-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Color</th>
                    <th>Related</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        1
                    </td>
                    <td>
                        Light Blue
                    </td>
                    <td>
                        Blue
                    </td>
                    <td>
                        
                        <button type="button" title="Edit" id="edit-button" >
                            <i class="fal fa-file-edit"> </i>
                        </button>
                        <a href="#" class="pl-2 text-sm">
                            <i class="fal fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <tr class="whitespace-nowrap table-border-bottom">
                    <td class="px-5 py-2 text-red-500 text-table text-center">
                        Not Data Found!
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- <table-pagination :pagination-lists="getPaginatedData" :max-visible-buttons="5" :mutationName="mutationName"
            pagination-url="categories?" /> -->
        <!-- Modal -->
        <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
            id="create_modal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true" ref="modal">
            <div class="modal-dialog !mt-[20vh] relative w-auto pointer-events-none">
                <form>
                    <div
                        class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                        <div class="modal-header border-b-0 px-2">
                            <p class="pt-8 px-8 text-base">
                                Color Name
                            </p>
                        </div>
                        <div class="modal-body px-2 mx-2">
                            <div class="block p-6 rounded-lg bg-white">
                                <div class="form-group mb-6">
                                    <label for="name" class="form-label label-form">Name</label>
                                    <input type="text"
                                        class="form-control input-form mt-3 block w-full px-3 py-1.5" id="name" placeholder="Name" />
                                    <!-- <p class=" text-validation text-sm">
                                        validationMsg
                                    </p> -->
                                </div>
                                <div class="form-group mb-6">
                                    <label
                                        for="photo"
                                        class="form-label label-form"
                                        >Color Photo</label
                                        >
                                        <input
                                            type="file"
                                            class="form-control input-form mt-3"
                                            id="photo"
                                            placeholder=""
                                            ref="iconFile"
                                            accept=".xlsx, .png, .gif, .jpeg, .jpg, .webp, .PNG, .JPG"
                                        />
                                </div>
                                <div class="form-group mb-6">
                                    <label for="main" class="form-label label-form">Main Color</label>
                                    <input type="text"
                                        class="form-control input-form mt-3 block w-full px-3 py-1.5" id="main" placeholder="Main Color" />
                                    <!-- <p class=" text-validation text-sm">
                                        validationMsg
                                    </p> -->
                                </div>

                                
                            </div>
                        </div>

                        <div class="modal-footer modal-footer-box justify-start px-8 pt-0 pb-8 mx-2">
                            <button type="button"
                                class="px-6 py-2.5 mr-6 primary-button">
                                Save
                            </button>
                            <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal" id="cancel">
                                Cancel
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

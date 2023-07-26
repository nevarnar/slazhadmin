@extends('layouts.main')
@section('title', ' Series')
@section('content')
    


    <div class="inner-main-container">
        <div>
            <p class="page-tittle ">Series Management</p>
        </div>
        <div class="relative flex justify-between">
            <!-- <SearchBox
                :typeOfSearch="typeOfSearch"
                :mutationName="mutationName"
            /> -->
            <div>
                <div class="inline-block">
                    @include('layouts.search_box') 
                </div>
                <div class="inline-block mx-1">
                    <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded-sm bg-white px-3 py-1.5 mt-2"
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
            
            <!-- <createbtn v-on:open_create_modal="clearFormData" /> -->
            <div>
                @include('layouts.create_button') 
            </div>
        </div>
        <div class="block">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Series Name</th>
                        <th>Sub Category</th>
                        <th>Brand</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            1
                        </td>
                        <td>
                            AC 12
                        </td>
                        <td>
                            Pant
                        </td>
                        <td>
                            Puma
                        </td>
                        <td>
                            
                            <button
                                type="button"
                                title="Edit"
                                id="edit-button"
                            >
                                <i class="fal fa-file-edit"></i>
                            </button>
                            <button
                                type="button"
                                title="Delete"
                                id="delete-button"
                            >
                                <a href="#">
                                    <i class="fal fa-trash"></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedData"
                :max-visible-buttons="5"
                :typeOfSearch="typeOfSearch"
                :mutationName="mutationName"
                pagination-url="categories?"
            />



        </div>
    </div>


            <!-- Modal -->
            <div
                class="modal fade primary-modal"
                id="create_modal"
                tabindex="-1"
                aria-labelledby="createModalLabel"
                aria-hidden="true"
                ref="modal"
            >
                <div class="modal-dialog modal-box">
                    <form>
                        <div
                            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current"
                        >
                            <div class="modal-header border-b-0">
                                <p class="pt-8 px-8 text-base">
                                    Create New Series 
                                </p>
                            </div>
                            <div class="modal-body px-2">
                                <div
                                    class="block p-6 rounded-lg bg-white max-w-sm"
                                >
                                    <div class="form-group mb-6">
                                        <label
                                            for="series"
                                            class="form-label label-form" 
                                            >Series</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control input-form mt-2"
                                            id="series"
                                            placeholder=""
                                        />
                                        
                                    </div>

                                    <div class="form-group mb-6">
                                        <label
                                            for="sub_category"
                                            class="form-label label-form"
                                            >Sub Category </label
                                        >
                                        <input
                                            type="text"
                                            class="form-control input-form mt-2"
                                            id="sub_category"
                                            placeholder=""
                                        />
                                    </div>

                                    <div class="form-group mb-6">
                                        <label
                                            for="brand"
                                            class="form-label label-form"
                                            >Brand</label
                                        >
                                        <input
                                            type="number"
                                            class="form-control input-form mt-2"
                                            id="brand"
                                            placeholder=""
                                        />
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-start px-8 pt-0 pb-8">
                                <button
                                    type="button"
                                    class="primary-button bg-black"
                                >
                                    Create
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
                        </div>
                    </form>
                </div>
            </div>


     

@endsection

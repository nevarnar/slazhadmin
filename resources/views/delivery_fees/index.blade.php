
@extends('layouts.main')
@section('title', ' Delivery Fees')
@section('content')
    

<township-list />
    {{-- <div class="inner-main-container">
        <div>
            <p class="page-tittle">Delivery Fees</p>
        </div>
        <div class="relative flex justify-between">
            <div class="flex">
                <div class="form-check inline-block ml-3 mr-2">
                    <input
                        class="form-check-input input-check float-center"
                        type="checkbox"
                        value=""
                    />
                </div>
                <div class="list-component">
                    <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="99" disabled selected>Town</option>
                        <option value="1">Town</option>
                        <option value="2">City</option>
                        <option value="3">Township</option>
                    </select>
                </div>
                <div class="list-component">
                    <SearchBox
                        :pagination-url="paginationUrl"
                        :mutationName="mutationName"
                    />
                </div>
                    
            </div>
            <div>
                <button 
                    class="btn-clear create-btn"
                    type="button"
                >
                    <a href="#">Add Township</a>
                </button>
            </div>
        </div>
        <div class="block">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Township</th>
                        <th>Division</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            1
                        </td>
                        <td>
                            Aung Myae Thar San
                        </td>
                        <td>
                            Mdy
                        </td>
                        <td>
                            Amount
                        </td>
                        <td>
                            <button
                                type="button"
                                title="Edit Delivery Fees"
                                id="edit-button"
                                data-bs-toggle="modal"
                                data-bs-target="#edit_modal"
                                data-toggle="modal"
                            >
                                <i class="fal fa-file-edit"></i>
                            </button>
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
                    <!-- <tr
                        class="whitespace-nowrap table-border-bottom"
                    >
                        <td colspan="5" class="px-5 py-2 text-red-500 text-table text-center">
                            Not Data Found!
                        </td>
                    </tr> -->
                </tbody>
            </table>
            <table-pagination
                :pagination-lists="getPaginatedData"
                :max-visible-buttons="5"
                :mutationName="mutationName"
                pagination-url="categories?"
            />
            <!-- Modal -->
            <div
                class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
                id="edit_modal"
                tabindex="-1"
                aria-labelledby="editModalLabel"
                aria-hidden="true"
                ref="modal"
            >
                <div class="modal-dialog relative w-auto pointer-events-none">
                    <form>
                        <div
                            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current"
                        >
                            <div class="modal-header border-b-0 px-2">
                                <p class="pt-8 px-8 text-base">
                                    Edit Delivery Fees
                                </p>
                            </div>
                            <div class="modal-body px-2 mx-2">
                                <div
                                    class="block p-6 rounded-lg bg-white"
                                >
                                    <div class="form-group mb-6">
                                        <label
                                            for="name"
                                            class="form-label label-form"
                                            >Charges</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control input-form mt-3"
                                            
                                            id="name"
                                            placeholder=""
                                        />
                                    </div>

                                </div>
                            </div>

                            <div
                                class="modal-footer modal-footer-box justify-start px-8 pt-0 pb-8 mx-2"
                            >
                                <button
                                    type="button"
                                    class="px-6 py-2.5 mr-6 primary-button"
                                >
                                    Save
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-light px-3"
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
        </div>
    </div> --}}


@endsection





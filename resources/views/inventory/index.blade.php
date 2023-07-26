@extends('layouts.main')
@section('title', ' Inventory')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Inventroy Management</p>
        </div>
        <div class=" relative flex justify-between">
            @include('layouts.search_box')
            <div>
                @include('layouts.create_button')
            </div>
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                                    Shelf Name
                        </th>
                        <th>
                                    Number of Floors
                        </th>
                        <th>
                                    Sub Category
                        </th>
                        <th>
                                    Action
                        </th>
                    </tr>        
                </thead>
                <tbody>
                    <tr>
                        <td>
                                1
                        </td>
                        <td >
                                    A
                        </td>
                        <td>
                                    5
                        </td>
                        <td >
                                    Sub Category
                        </td>
                        <td>
                            <button type="button" title="Edit" id="edit-button"
                                data-bs-toggle="modal" data-bs-target="#edit_modal">
                                <i class="fal fa-file-edit"></i>
                            </button>
                            <button type="button" title="Delete" id="delete_button"
                                data-bs-toggle="modal" data-bs-target="#delete_modal">
                                <i class="fal fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                                2
                        </td>
                        <td >
                                    B
                        </td>
                        <td >
                                    5
                        </td>
                        <td >
                                    Sub Category
                        </td>
                        <td>
                            <button type="button" title="Edit" id="edit-button"
                                data-bs-toggle="modal" data-bs-target="#edit_modal">
                                <i class="fal fa-file-edit"></i>
                            </button>
                            <button type="button" title="Delete" id="delete_button"
                                data-bs-toggle="modal" data-bs-target="#delete_modal">
                                <i class="fal fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    

                </tbody>
            </table>
        </div>
    </div>

    @include('layouts.delete_modal')
    <!-- Modal -->
<div class="modal fade primary-modal" id="create_modal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-box">
    <div class="modal-content content-modal">

        <div class="modal-header border-b-0 mx-2">
            <p class="pt-8 px-8 text-base">Create Inventory</p>
        </div>
        <div class="modal-body px-2 mx-2">
            <form>
                <div class="block p-6 rounded-lg bg-white">
                    <div class="form-group mb-6">
                        <label for="engName" class="form-label label-form">Inventory Name</label>
                        <input type="text" class="form-control input-form mt-3"
                                id="engName" placeholder="">
                    </div>
                    <div class="form-group mb-6">
                        <label for="mmName" class="form-label label-form">Amount of Floor</label>
                        <input type="text" class="form-control input-form mt-3"
                                id="mmName" placeholder="">
                    </div>
                </div>
            </form>
        </div>
            
        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end px-8 mx-2 mt-2 pt-0 pb-8">
            <button type="button" class="primary-button bg-black" data-bs-dismiss="modal">
            Create
            </button>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        
        </div>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<div class="modal fade primary-modal" id="edit_modal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-box">
    <div class="modal-content content-modal">
        <div class="modal-header border-b-0 mx-2">
            <p class="pt-8 px-8 text-base">Edit Inventory</p>
        </div>
        <div class="modal-body px-2 mx-2">
            <form>
                <div class="block p-6 rounded-lg bg-white">
                    <div class="form-group mb-6">
                        <label for="engName" class="form-label label-form">Inventory Name</label>
                        <input type="text" class="form-control input-form mt-3" 
                                id="engName" placeholder="">
                    </div>
                    <div class="form-group mb-6">
                        <label for="mmName" class="form-label label-form">Amount of Floor</label>
                        <input type="text" class="form-control input-form mt-3" 
                                id="mmName" placeholder="">
                    </div>
                </div>
            </form>
        </div>
            
        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end px-8 mx-2 mt-2 pt-0 pb-8">
            <button type="button" class="primary-button bg-black" data-bs-dismiss="modal">
            Edit
            </button>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        
        </div>
    </div>
  </div>
</div>


@endsection
























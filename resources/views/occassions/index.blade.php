@extends('layouts.main')
@section('title', ' Occassion')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Occassion Management</p>
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
                            Name
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
                        <td>
                            Traditional
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
                        <td>
                            Dress
                        </td>
                        <td>
                            <button type="button" title="Edit" id="edit-button"
                                data-bs-toggle="modal" data-bs-target="#edit_modal">
                                <i class="fal fa-file-edit" ></i>
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
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="create_modal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-auto pointer-events-none">
    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">

        <div class="modal-header border-b-0">
            <p class="pt-8 px-8 text-base">Create Occassion</p>
        </div>
        <div class="modal-body px-2">
            <form>
                <div class="block p-6 rounded-lg    bg-white max-w-sm">
                    <div class="form-group mb-6">
                        <label for="engName" class="form-label label-form">Occassion Name ( In English )</label>
                        <input type="text" class="form-control input-form mt-3" 
                                id="engName" placeholder="">
                    </div>
                    <div class="form-group mb-6">
                        <label for="mmName" class="form-label label-form">Occassion Name ( In Myanmar )</label>
                        <input type="text" class="form-control input-form mt-3" 
                                id="mmName" placeholder="">
                    </div>
                        
                    <div class="form-group mb-6">
                        <label for="icon" class="form-label label-form">Occassion Icon</label>
                        <input type="file"
                                class="form-control input-form mt-3"
                                id="icon" placeholder="">
                    </div>
                        
                </div>
            </form>
        </div>
            
        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-start px-8 pt-0 pb-8">
            <button type="button" class="primary-button bg-black " data-bs-dismiss="modal">
            Create
            </button>
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        
        </div>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="edit_modal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">

            <div class="modal-header border-b-0">
                <p class="pt-8 px-8 text-base">Edit Color</p>
            </div>
            <div class="modal-body px-2">
                <form>
                    <div class="block p-6 rounded-lg    bg-white max-w-sm">
                        <div class="form-group mb-6">
                            <label for="engName" class="form-label label-form">Occassion Name ( In English )</label>
                            <input type="text" class="form-control input-form mt-3
                                    block w-full px-3 py-1.5 text-gray-700
                                    bg-white bg-clip-padding border border-solid border-gray-300
                                    rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none" 
                                    id="engName" placeholder="">
                        </div>
                        <div class="form-group mb-6">
                            <label for="mmName" class="form-label label-form">Occassion Name ( In Myanmar )</label>
                            <input type="text" class="form-control input-form mt-3
                                    block w-full px-3 py-1.5 text-gray-700
                                    bg-white bg-clip-padding border border-solid border-gray-300
                                    rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600  focus:shadow-none focus:outline-none" 
                                    id="mmName" placeholder="">
                        </div>
                        
                        <div class="form-group mb-6">
                            <label for="icon" class="form-label label-form">Occassion Icon</label>
                            <input type="file"
                                    class="form-control input-form mt-3
                                    block w-full px-3 py-1.5 text-gray-700
                                    bg-white bg-clip-padding border border-solid border-gray-300
                                    rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    id="icon" placeholder="">
                        </div>
                        
                    </div>
                </form>
            </div>
            
            <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-start px-8 pt-0 pb-8">
                <button type="button" class="px-6 py-2.5 mr-5
                    bg-black text-white
                    font-medium
                    text-xs
                    leading-tight
                    hover:bg-black
                    focus:bg-black focus:outline-none focus:ring-0
                    active:bg-black" data-bs-dismiss="modal">
                    Edit
                </button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
        
            </div>
        </div>
    </div>
</div>


@endsection
























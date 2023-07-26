@extends('layouts.main')
@section('title', ' Admins')
@section('content')
 
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Admins Management</p>
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
                        Phone
                    </th>
                    <th>
                        Department
                    </th>
                    <th>
                        Roles
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                    @for ($i = 1; $i < 4; $i++)
                    <tr>
                        <td>
                            {{ $i }}
                        </td>
                        <td>
                            Jon doe {{ $i }}
                        </td>
                        <td>
                            0999885522{{ $i }}
                        </td>
                        <td>
                            Admin {{ $i }}
                        </td>
                        <td>
                            Admin {{ $i }}
                        </td>

                        <td>
                            <button type="button" title="Edit" id="">
                                <a href="#">
                                    <i class="fal fa-file-edit"></i>
                                </a>
                            </button>
                            <button type="button" title="Delete" id=""
                                    data-bs-toggle="modal" data-bs-target="#delete_modal">
                                    <i class="fal fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endfor

                </tbody>
            </table>

            <!-- Modal -->
            <div
                class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
                id="create_modal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog relative w-auto pointer-events-none">
                    <div
                        class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
                        <div
                            class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">
                                Modal title
                            </h5>
                            <button type="button"
                                    class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                                    data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body relative p-4">
                            Modal body text goes here.
                        </div>
                        <div
                            class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                            <button type="button" class="px-6
                                py-2.5 bg-purple-600
                                text-white font-medium text-xs leading-tight uppercase rounded
                                shadow-md hover:bg-purple-700 hover:shadow-lg focus:bg-purple-700 focus:shadow-lg focus:outline-none focus:ring-0
                                active:bg-purple-800 active:shadow-lg
                                transition duration-150 ease-in-out" data-bs-dismiss="modal">Close
                            </button>

                        </div>
                        
                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection

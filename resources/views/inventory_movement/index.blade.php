@extends('layouts.main')
@section('title', ' Inventory Movement')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Inventory Movement</p>
        </div>
        <div class=" relative flex justify-between">
            <div>
                <div class="form-check inline-block ml-3 mr-2">
                    <input class="form-check-input appearance-none h-4 w-4 border border-gray-300
                    rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600
                    focus:outline-none transition duration-200 my-1 align-top bg-no-repeat
                    bg-center bg-contain float-center cursor-pointer" type="checkbox" value="">
                </div>
                <div class="inline-block mx-1">
                    <select name="" class="w-full text-gray-500 text-xs border rounded-sm bg-white px-3 py-1.5 mt-2"
                                id=""
                                placeholder="S/M/L">
                        <option value="" disabled selected> Bulk Action</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                <div class="inline-block ml-1 mr-1.5">
                    <select name="" class="w-full text-gray-500 text-xs border rounded-sm bg-white px-3 py-1.5 mt-2" id=""
                        placeholder="S/M/L">
                        <option value="" disabled selected> Filter</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                <div class="inline-block">
                    @include('layouts.search_box')
                </div>
            </div>
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
                            Product Name
                        </th>
                        <th>
                            Item Code
                        </th>
                        <th>
                            Series
                        </th>
                        <th>
                            Types
                        </th>
                        <th>
                            Stage
                        </th>
                        <th>
                            Sending Date
                        </th>
                        <th>
                            Arrival Date
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-bs-toggle="collapse" data-bs-target="#detail" aria-expanded="false"
                        aria-controls="detail">
                        <td>
                            1
                        </td>
                        <td>
                            H&M Jean
                        </td>
                        <td>
                            ABC-123
                        </td>
                        <td>
                            A102
                        </td>
                        <td>
                            Newly In
                        </td>
                        <td>
                            Done
                        </td>
                        <td>

                        </td>
                        <td>
                            27 July 2022
                        </td>
                        <td>
                            <button type="button" title="Edit" id="edit-button"
                                data-bs-toggle="modal" data-bs-target="#edit_modal">
                                <i class="fal fa-info-circle"></i>
                            </button>
                        </td>
                    </tr>


                    <tr class="collapse" id="detail">
                        <td colspan="8">
                            <div class="relative flex w-full">
                                <div class="pr-6 pt-3 pl-10 pb-6 bg-inherit inline-block relative">
                                    <img src="{{ asset('img/item_1.jpeg') }}" alt="">

                                </div>
                                <div class="w-full">
                                    <table class="secondary-table">
                                        <thead class="secondary-table-thead">
                                            <tr>
                                                <th class="sec-thead-th">
                                                    Shelf
                                                </th>
                                                <th class="sec-thead-th">
                                                    Amount
                                                </th>
                                                <th class="sec-thead-th">

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="sec-table-td">
                                                            A1
                                                </td>
                                                <td class="sec-table-td">
                                                            90
                                                </td>
                                                    <td class="pr-10 py-1 text-right w-full">
                                                    <button type="button" class="btn-clear text-gray-400 text-table mr-8" title="Transfer" id="transfer-button"
                                                        data-bs-toggle="modal" data-bs-target="#transfer_modal">
                                                        Transfer
                                                    </button>
                                                    <button type="button" class="btn-clear text-gray-400 text-table" title="Defect" id="defect_button"
                                                        data-bs-toggle="modal" data-bs-target="#delete_modal">
                                                        Defect
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="sec-table-td">
                                                            A1
                                                </td>
                                                <td class="sec-table-td">
                                                            90
                                                </td>
                                                <td class="pr-10 py-1 text-right w-full">
                                                    <button type="button" class="btn-clear text-gray-400 text-table mr-8" title="Transfer" id="transfer-button"
                                                        data-bs-toggle="modal" data-bs-target="#transfer_modal">
                                                        Transfer
                                                    </button>
                                                    <button type="button" class="btn-clear text-gray-400 text-table" title="Defect" id="delete_button"
                                                        data-bs-toggle="modal" data-bs-target="#delete_modal">
                                                    Defect
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr data-bs-toggle="collapse" data-bs-target="#detail" aria-expanded="false"
                        aria-controls="detail">
                        <td>
                            1
                        </td>
                        <td>
                            H&M Jean
                        </td>
                        <td>
                            ABC-123
                        </td>
                        <td>
                            A102
                        </td>
                        <td>
                            Newly In
                        </td>
                        <td>
                            Done
                        </td>
                        <td>
                            27 July 2022
                        </td>
                        <td>

                        </td>
                        <td>
                            <button type="button" title="Edit" id="edit-button"
                                data-bs-toggle="modal" data-bs-target="#edit_modal">
                                <i class="fal fa-info-circle"></i>
                            </button>
                        </td>
                    </tr>


                    <tr class="collapse" id="detail">
                        <td colspan="8">
                            <div class="relative flex w-full">
                                <div class="pr-6 pt-3 pl-10 pb-6 bg-inherit inline-block relative">
                                    <img src="{{ asset('img/item_1.jpeg') }}" alt="">

                                </div>
                                <div class="w-full">
                                    <table class="secondary-table">
                                        <thead class="secondary-table-thead">
                                            <tr>
                                                <th class="sec-thead-th">
                                                    Shelf
                                                </th>
                                                <th class="sec-thead-th">
                                                    Amount
                                                </th>
                                                <th class="sec-thead-th">

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="sec-table-td">
                                                            A1
                                                </td>
                                                <td class="sec-table-td">
                                                            90
                                                </td>
                                                    <td class="pr-10 py-1 text-right w-full">
                                                    <button type="button" class="btn-clear text-gray-400 text-table mr-8" title="Transfer" id="transfer-button"
                                                        data-bs-toggle="modal" data-bs-target="#transfer_modal">
                                                        Transfer
                                                    </button>
                                                    <button type="button" class="btn-clear text-gray-400 text-table" title="Defect" id="defect_button"
                                                        data-bs-toggle="modal" data-bs-target="#delete_modal">
                                                        Defect
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="sec-table-td">
                                                            A1
                                                </td>
                                                <td class="sec-table-td">
                                                            90
                                                </td>
                                                <td class="pr-10 py-1 text-right w-full">
                                                    <button type="button" class="btn-clear text-gray-400 text-table mr-8" title="Transfer" id="transfer-button"
                                                        data-bs-toggle="modal" data-bs-target="#transfer_modal">
                                                        Transfer
                                                    </button>
                                                    <button type="button" class="btn-clear text-gray-400 text-table" title="Defect" id="delete_button"
                                                        data-bs-toggle="modal" data-bs-target="#delete_modal">
                                                    Defect
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>


                </tbody>
            </table>
        </div>
    </div>

    @include('layouts.delete_modal')
    <!-- Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="transfer_modal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-auto pointer-events-none">
    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">

        <div class="modal-header border-b-0">
            <p class="pt-8 px-8 text-base">Transfer Item</p>
        </div>
        <div class="modal-body px-2">
            <form>
                <div class="block p-6 rounded-lg    bg-white max-w-sm">
                    <div class="form-group mb-6">
                        <label for="amount" class="form-label label-form">Amount</label>
                        <input type="text" class="form-control input-form mt-3"
                                id="amount" placeholder="">
                    </div>
                    <div class="form-group mb-6">
                        <label for="to" class="form-label label-form">To</label>
                        <input type="text" class="form-control input-form mt-3"
                                id="to" placeholder="">
                    </div>



                </div>
            </form>
        </div>

        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-start px-8 pt-0 pb-8">
            <button type="button" class="px-6 py-2.5 mr-5
            bg-black primary-button" data-bs-dismiss="modal">
            Transfer
            </button>
            <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button> -->

        </div>
    </div>
  </div>
</div>




@endsection

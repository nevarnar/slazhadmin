@extends('layouts.main')
@section('title', ' Discount Product List')
@section('content')


    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Discount Product List</p>
        </div>
        <div class="relative flex justify-between">
            <div class="flex">
                <div class="list-component">
                    <SearchBox
                        :pagination-url="paginationUrl"
                        :mutationName="mutationName"
                    />
                </div>
                <div class="list-component">
                    <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="" disabled selected>Bulk Action</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                <div class="list-component">
                    <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="" disabled selected>Type</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
            </div>
            <div>
                <button 
                    class="btn-clear create-btn"
                    type="button"
                >
                    <a href="#">Add</a>
                </button>
            </div>
        </div>
        <div class="block">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Item Code</th>
                        <th>Discount Amount</th>
                        <th>Starting Date</th>
                        <th>Ending Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                           1
                        </td>
                        <td>
                            item one
                        </td>
                        <td>
                            32ks
                        </td>
                        <td>
                            3 May 2022
                        </td>
                        <td>
                            10 May 2022
                        </td>
                        <td>
                            
                            <button
                                type="button"
                                title="Edit"
                                class="mr-3"
                            >
                                <i class="fal fa-file"></i>
                            </button>
                             <button
                                type="button"
                                title="Delete"
                                class=""
                            >
                                <i class="fal fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    <tr
                        class="whitespace-nowrap table-border-bottom"
                    >
                        <td colspan="5" class="px-5 py-2 text-red-500 text-table text-left">
                            Not Data Found!
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- <table-pagination
                :pagination-lists="getPaginatedData"
                :max-visible-buttons="5"
                :mutationName="mutationName"
                pagination-url="categories?"
            /> -->

            
        </div>
    </div>

@endsection

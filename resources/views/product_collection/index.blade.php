@extends('layouts.main')
@section('title', 'Product Collection')
@section('content')

<div class="inner-main-container">
        <div>
            <p class="page-tittle">Styles Management</p>
        </div>
        <div class="relative flex justify-between">
            <div>
                <div class="form-check inline-block ml-3 mr-2">
                    <input
                        class="form-check-input input-check float-center"
                        type="checkbox"
                        value=""
                    />
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
                <div class="inline-block ml-1 mr-1.5">
                    <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded-sm bg-white px-3 py-1.5 mt-2"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="" disabled selected>Filter</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                <div class="inline-block">
                    <SearchBox
                        :method="search"
                        :typeOfSearch="typeOfSearch"
                        :mutationName="mutationName"
                    />
                </div>
            </div>
            <div>
                <createbtn v-on:open_create_modal="onCreate" />
            </div>
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Collection Name</th>
                        <th>Collection Code</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbl">
                    <tr v-for="style in myStylePaginatedData" :key="style.id">
                        <td>1</td>
                        <td>Collection 1</td>
                        <td>ABC-123</td>
                        <td>
                            Traditional
                        </td>
                        <td>
                            <button
                                type="button"
                                title="Edit"
                                id="edit_button"
                                class="edit-btn"
                            >
                                <a href="#">
                                    <i class="fal fa-file-edit"></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
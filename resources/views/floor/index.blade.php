@extends('layouts.main')
@section('title', ' Floor List')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle mb-0">Shelf & Floors</p>
        </div>
        <div class="relative flex justify-between">
                <div>
                    <p class="text-sm text-gray-600 pt-2 pl-2">
                        Inventory One
                    </p>
            </div>
                <div class="mx-1 mb-3">
                    <select
                        name=""
                        class="w-full text-gray-500 text-xs border rounded-sm bg-white px-3 py-1.5"
                        id=""
                        placeholder="S/M/L"
                    >
                        <option value="" disabled selected>Shelf</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
                
            
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Floor </th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>A1</td>
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
        </div>
    </div>
  




@endsection

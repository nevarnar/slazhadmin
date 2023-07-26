@extends('layouts.main')
@section('title', ' Size Chart')
@section('content')

<div class="inner-main-container">
    <div>
        <p class="page-tittle">Size Chart Management</p>
    </div>
    <div class=" relative flex justify-between">
        @include('layouts.search_box')
        <div>
            <a href="/size_chart/create" class="a-clear create-btn" type="button" style="margin-top: 8px">
                Add New
            </a>
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
                        Vigo
                    </td>
                    <td>
                        <button type="button" title="Edit" id="edit-button">
                            <a href="#">
                                <i class="fal fa-file-edit"></i>
                            </a>
                        </button>
                        <button type="button" title="Delete" id="delete-button">
                            <a href="#">
                                <i class="fal fa-trash"></i>
                            </a>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        2
                    </td>
                    <td>
                        Zara
                    </td>
                    <td>
                        <button type="button" title="Edit" id="edit-button">
                            <a href="#">
                                <i class="fal fa-file-edit "></i>
                            </a>
                        </button>
                        <button type="button" class="btn-clear" title="Delete" id="delete-button">
                            <a href="#">
                                <i class="fal fa-trash"></i>
                            </a>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>
                        3
                    </td>
                    <td>
                            H&M
                    </td>
                    <td>
                        <button type="button" title="Edit" id="edit-button">
                            <a href="#">
                                <i class="fal fa-file-edit"></i>
                            </a>
                        </button>
                        <button type="button" title="Delete" id="delete-button">
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
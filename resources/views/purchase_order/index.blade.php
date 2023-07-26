@extends('layouts.main')
@section('title', ' Purchase Order')
@section('content')

<div class="inner-main-container">
    <div>
        <p class="page-tittle">Purchase_order</p>
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
                        Invoice ID
                    </th>
                    <th>
                        Supplier
                    </th>
                    <th>
                        Date
                    </th>
                    <th>
                        Amount
                    </th>
                    <th>
                        Status
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
                        aung ye lin
                    </td>
                    <td>
                        12 March 2022
                    </td>
                    <td>
                            120,000
                    </td>
                    <td>
                        <div class="text-table text-ordered">
                            Ordered
                        </div>
                    </td>
                    <td>
                        <button type="button" title="Edit" id="">
                            <a href="#">
                                <i class="fal fa-file-edit"></i>
                            </a>
                        </button>
                        <button type="button" title="Delete" id="">
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
                            KO Ko
                    </td>
                    <td>
                            12 March 2022
                    </td>
                    <td>
                            120,000
                    </td>
                    <td>
                        <div class="text-table text-received">
                            Received
                        </div>
                    </td>
                    <td>
                        <button type="button" title="Edit" id="">
                            <a href="#">
                                <i class="fal fa-file-edit"></i>
                            </a>
                        </button>
                        <button type="button" title="Delete" id="">
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
                                Thaw zin
                        </td>
                        <td>
                            13 March 2022
                        </td>
                        <td>
                            120,000
                        </td>
                        <td>
                            <div class="text-table text-cancelled">
                                Cancelled
                            </div>
                        </td>
                        <td>
                            <button type="button" title="Edit" id="">
                                <a href="#">
                                    <i class="fal fa-file-edit"></i>
                                </a>
                            </button>
                            <button type="button" title="Delete" id="">
                                <a href="#">
                                    <i class="fal fa-trash"></i>
                                </a>
                            </button>
                        </td>
                    </tr>



            </tbody>
        </table>
        <div class="flex justify-start mt-4">
            <nav aria-label="Page navigation example">
                <ul class="flex list-style-none">
                    <li class="page-item disabled">
                        <a
                        class="pagination-link page-link normal-pagination"
                            href="#" tabindex="-1" aria-disabled="true">
                            Previous
                        </a>
                    </li>
                    <li class="page-item">
                        <a
                            class="pagination-link page-link normal-pagination"
                            href="#">
                            1
                        </a>
                    </li>
                    <li class="page-item active">
                        <a
                            class="pagination-link page-link active-pagination"
                            href="#">
                            2 <span class="visually-hidden">(current)</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a
                            class="pagination-link page-link normal-pagination"
                            href="#">
                            3
                        </a>
                    </li>
                    <li class="page-item">
                        <a
                            class="pagination-link page-link normal-pagination"
                            href="#">
                            Next
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>



@endsection

@extends('layouts.main')
@section('title', ' Supplier Items')
@section('content')


<!-- 'item waiting from supplier' in figma -->

    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Supplier Items</p>
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
                                    Ko ko {{ $i }}
                        </td>
                        <td>
                            {{ ($i+3)*2 }} March 2022
                        </td>
                        <td>
                            <button type="button" title="" >
                                <a href="/inventory_confirmation_detail">
                                    <i class="fal fa-layer-group"></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>

@endsection

@extends('layouts.main')
@section('title', ' Inventory Confirmed Record')
@section('content')


    <div class="inner-main-container">
        <div>
            <p class="page-tittle">
                Inventory Confirmed Record
            </p>
        </div>
        <div class="relative flex justify-between">
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
                                    Confirmed Date
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
                            Khin mg toe {{ $i }}
                        </td>
                        <td>
                            {{ ($i+3)*2 }} March 2022
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>

@endsection

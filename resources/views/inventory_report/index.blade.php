@extends('layouts.main')
@section('title', ' Report From Inventory')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle"> Report From Inventory Manager</p>
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
                                    Ordered Date
                        </th>
                        <th>
                                    Amount
                        </th>
                        <th>
                                    Action
                        </th>
                    </tr>        
                </thead>
                <tbody>
                    <tr
                        data-bs-toggle="collapse" data-bs-target="#detail" aria-expanded="false"
                            aria-controls="detail">
                        <td>
                            1
                        </td>
                        <td>
                            Ko ko
                        </td>
                        <td>
                            12 March 2022
                        </td>
                        <td>
                            1111 
                        </td>
                        <td>
                            <button type="button" title="" id="">
                                <a href="/inventory_confirmation_detail" class="a-clear">
                                    <i class="fal fa-info-circle"></i>
                                </a>
                            </button>
                        </td>
                    </tr>
                    <tr class="collapse" id="detail">
                        <td colspan="8">
                            <div class="relative flex w-full">
                                <div class="w-full">
                                    <table class="inline-block table-auto secondary-table">
                                        <thead class="secondary-table-thead">
                                            <tr>
                                                <th class="sec-thead-th">
                                                    Item Code
                                                </th>
                                                <th class="sec-thead-th">
                                                    Product Name
                                                </th>
                                                <th class="sec-thead-th">
                                                    Brand
                                                </th>
                                                <th class="sec-thead-th">
                                                    Sub Category
                                                </th>
                                                <th class="sec-thead-th">
                                                    Product Size
                                                </th>
                                                <th class="sec-thead-th">
                                                    Quantity
                                                </th>
                                                <th class="sec-thead-th">
                                                    Type
                                                </th>
                                                <th class="sec-thead-th">
                                                    Remark
                                                </th>
                                                <th class="sec-thead-th">

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="sec-table-td">
                                                    1001
                                                </td>
                                                <td class="sec-table-td">
                                                    Levis Pants
                                                </td>
                                                <td class="sec-table-td">
                                                    Levis
                                                </td>
                                                <td class="sec-table-td">
                                                    Pants
                                                </td>
                                                <td class="sec-table-td">
                                                    16
                                                </td>
                                                <td class="sec-table-td">
                                                    10
                                                </td>
                                                <td class="sec-table-td">
                                                    Defect
                                                </td>
                                                <td class="sec-table-td">
                                                    Weather
                                                </td>
                                                <td class="sec-table-td">
                                                    <button type="button" class="mr-3" title="" id="">
                                                        <i class="fal fa-check"></i>
                                                    </button>
                                                    <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                                        <i class="fal fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="sec-table-td">
                                                    1001
                                                </td>
                                                <td class="sec-table-td">
                                                    Levis Pants
                                                </td>
                                                <td class="sec-table-td">
                                                    Levis
                                                </td>
                                                <td class="sec-table-td">
                                                    Pants
                                                </td>
                                                <td class="sec-table-td">
                                                    16
                                                </td>
                                                <td class="sec-table-td">
                                                    10
                                                </td>
                                                <td class="sec-table-td">
                                                    Defect
                                                </td>
                                                <td class="sec-table-td">
                                                    Defect
                                                </td>
                                                <td class="sec-table-td">
                                                    <button type="button" class="mr-3" title="" id="">
                                                        <i class="fal fa-check"></i>
                                                    </button>
                                                    <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                                        <i class="fal fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            2
                        </td>
                        <td>
                            Kyaw Gyi
                        </td>
                        <td>
                            14 April 2022
                        </td>
                        <td>
                            12211
                        </td>
                        <td>
                            <button type="button" class="btn-clear" title="" id=""
                                >
                                <a href="/inventory_confirmation_detail" class="a-clear">
                                    <i class="fal fa-info-circle fw300" style="color:#68728c;"></i>
                                </a>
                            </button>
                            
                        </td>
                    </tr>
                    

                </tbody>
            </table>
            
        </div>
    </div>




@endsection

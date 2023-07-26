@extends('layouts.main')
@section('title', ' Credit')
@section('content')
    

<div class="inner-main-container">
    <div>
        <p class="page-tittle">Supplier Name : Khint Wint Whar</p>
    </div>
    
    <div class="block">
        <table class="primary-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        1
                    </td>
                    <td>
                        29 Feb
                    </td>
                    <td>
                        12,700,000
                    </td>
                    <td>
                        Credit Paid
                    </td>
                    <td>
                        
                        12,700,000
                    </td>
                </tr>
                <tr>
                    <td>
                        1
                    </td>
                    <td>
                        30 Feb
                    </td>
                    <td>
                        12,700,000
                    </td>
                    <td>
                        Credit Received
                    </td>
                    <td>
                        
                        12,700,000
                    </td>
                </tr>
                <tr class="whitespace-nowrap table-border-bottom">
                    <td class="px-5 py-2 text-red-500 text-table text-center">
                        Not Data Found!
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- <table-pagination :pagination-lists="getPaginatedData" :max-visible-buttons="5" :mutationName="mutationName"
            pagination-url="categories?" /> -->
        
    </div>
</div>


@endsection

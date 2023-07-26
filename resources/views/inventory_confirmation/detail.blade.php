@extends('layouts.main')
@section('title', ' Order Confirm')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle text-black text-sm">Invoice Form</p>
        </div>
        <div class="flex flex-row mt-4 pb-2 space-x-6">
            <div class="flex-none w-fit">
                <p class=" text-gray-900 text-13px mb-1">
                    Invoice Number
                </p>
                <p class=" text-gray-400 text-13px">
                    1123
                </p>
            </div>
            <div class="flex-none w-fit">
                <p class=" text-gray-900 text-13px mb-1">
                    Supplier Name
                </p>
                <p class=" text-gray-400 text-13px capitalize">
                     Mr.Kane
                </p>
            </div>
            <div class="flex-none w-fit mr-2">
                <p class=" text-gray-900 text-13px mb-1">
                    Date
                </p>
                <p class=" text-gray-400 text-13px">
                    13 / 11 /2021
                </p>
            </div>
        </div>
        <hr class="my-2 h-0.5 mb-4">


        <div class="relative block mb-2">
            <p class="page-tittle text-black text-13px">Order List</p>
        </div>
        <div class="block pb-8">
            <table class=" secondary-table overflow-hidden">
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
                            Shelf
                        </th>
                        <th class="sec-thead-th">
                                    Action
                        </th>
                    </tr>        
                </thead>
                <tbody class="bg-white">
                    <tr class="whitespace-nowrap">
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
                                A1
                        </td>
                        <td class="sec-table-td">
                            <button type="button" class="btn-clear mr-2" title="" id=""
                                >
                                <a href="#" class="a-clear">
                                <i class="fal fa-check"></i>
                                </a>
                            </button>
                            <button type="button" class="btn-clear" title="Error" id="error-button"
                                data-bs-toggle="modal" data-bs-target="#error_modal">
                                    <i class="fal fa-info-circle "></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="whitespace-nowrap">
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
                        <td class="px-5">
                            <div class="text-center w-full">
                                <!-- <input type="text" class="border w-16 focus:outline-none rounded-sm active:outline-nont"> -->
                                <input type="text" class="form-control input-form block w-20 px-3 py-0.5" 
                                id="" placeholder="">
                            </div>
                        </td>
                        <td class="sec-table-td">
                            <button type="button" class="btn-clear mr-2" title="" id=""
                                >
                                <a href="#" class="a-clear">
                                    <i class="fal fa-check"></i>
                                </a>
                            </button>
                            <button type="button" class="btn-clear" title="Error" id="error-button"
                                data-bs-toggle="modal" data-bs-target="#error_modal">
                                    <i class="fal fa-times w-4"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="whitespace-nowrap">
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
                                A1
                        </td>
                       <td class="sec-table-td">
                            <button type="button" class="btn-clear mr-2" title="" id=""
                                >
                                <a href="#" class="a-clear">
                                <i class="fal fa-check"></i>
                                </a>
                            </button>
                            <button type="button" class="btn-clear" title="Error" id="error-button"
                                data-bs-toggle="modal" data-bs-target="#error_modal">
                                    <i class="fal fa-info-circle"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="whitespace-nowrap">
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
                                A1
                        </td>
                        <td class="sec-table-td">
                            <button type="button" class="btn-clear mr-2" title="" id=""
                                >
                                <a href="#" class="a-clear">
                                <i class="fal fa-check"></i>
                                </a>
                            </button>
                            <button type="button" class="btn-clear" title="Error" id="error-button"
                                data-bs-toggle="modal" data-bs-target="#error_modal">
                                    <i class="fal fa-info-circle"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="whitespace-nowrap">
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
                                A1
                        </td>
                        <td class="sec-table-td">
                            <button type="button" class="btn-clear mr-2" title="" id=""
                                >
                                <a href="#" class="a-clear">
                                <i class="fal fa-check"></i>
                                </a>
                            </button>
                            <button type="button" class="btn-clear" title="Error" id="error-button"
                                data-bs-toggle="modal" data-bs-target="#error_modal">
                                    <i class="fal fa-info-circle"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="whitespace-nowrap">
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
                                A1
                        </td>
                        <td class="sec-table-td">
                            <button type="button" class="btn-clear mr-2" title="" id=""
                                >
                                <a href="#" class="a-clear">
                                <i class="fal fa-check"></i>
                                </a>
                            </button>
                            <button type="button" class="btn-clear" title="Error" id="error-button"
                                data-bs-toggle="modal" data-bs-target="#error_modal">
                                    <i class="fal fa-info-circle"></i>
                            </button>
                        </td>
                    </tr>
                    
                    

                </tbody>
            </table>

            <di class="flex justify-end mt-4">
                    <button type="button" class="primary-button bg-black">
                    Create
                    </button>
                </div>
        </div>
    </div>



<!-- Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="error_modal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog relative w-auto pointer-events-none">
    <div class="modal-content border-none shadow-lg relative flex flex-col w-11/12 pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">

        <div class="modal-header border-b-0 mx-4">
            <p class="pt-8 px-8 text-base">Error Form</p>
        </div>
        <div class="modal-body px-2 mx-4">
            <form>
                
                <div class="block p-6 rounded-lg bg-white space-y``">
                    <div class="form-group mb-6">
                        <label for="engName" class="form-label label-form">Type</label>
                        <select name="" class="w-full text-xs border rounded-sm bg-white py-1.5 mt-3" id=""
                                placeholder="...">
                            <option value="">Defect</option>
                            <option value="1">New One</option>
                        </select>
                    </div>
                    <div class="form-group mb-6">
                        <label for="mmName" class="form-label label-form">Quantity</label>
                        <input type="text" class="form-control input-form mt-3" 
                                id="mmName" placeholder="">
                    </div>
                        
                    <div class="form-group mb-6">
                        <label for="icon" class="form-label label-form">Remark</label>
                        <textarea name="" class="text-table form-textarea mt-2 w-full animated-textarea text-left h-24" id="" cols="30" rows="12"
                        style="border:1px solid #e5e7eb" placeholder=""></textarea>
                    </div>
                        
                </div>
            </form>
        </div>
            
        <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end 
        px-8 pt-0 pb-8 ml-4">
            <button type="button" class="primary-button bg-black  " data-bs-dismiss="modal">
            Create
            </button>
            <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button> -->
        
        </div>
    </div>
  </div>
</div>





<script>
    $(document).ready(function (){
        $('.normal').autosize();
        $('.animated-textarea').autosize();
        });
                
</script>
@endsection

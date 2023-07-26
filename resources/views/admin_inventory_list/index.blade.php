@extends('layouts.main')
@section('title', ' Stock List')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Stock List</p>
        </div>
        <div class=" relative flex justify-between">
            <div class="flex">
                <div class="form-check inline-block ml-3 mr-2">
                    <input class="form-check-input input-check float-center" type="checkbox" value="">
                </div>
                
                <div class="list-component">
                    @include('layouts.search_box')
                </div>
                <div class="inline-block mx-1">
                    <select name="" class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-0"
                                id=""
                                placeholder="S/M/L">
                        <option value="" disabled selected> Inventory Name</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>
            </div>
            <div>
                <div class="inline-block">
                    @include('layouts.create_button')
                </div>
                <div class="inline-block ml-1.5">
                    <button class="btn-clear create-btn" type="button"
                        style="margin-top: 0px">
                        
                        <i class="fal fa-exchange"></i>
                    </button>
                </div>
                
            </div>
        </div>
        <div class="block pb-8">
            <table class="table-auto primary-table">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Product Name
                        </th>
                        <th>
                            Item Code
                        </th>
                        <th>
                            Series
                        </th>
                        <th>
                            Product Sub Category
                        </th>
                        <th>
                            Brand
                        </th>
                        <th>
                            Shelf
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
                    <tr>
                        <td>
                            1
                        </td>
                        <td data-bs-toggle="collapse" data-bs-target="#detail" aria-expanded="false"
                        aria-controls="detail">
                            H&M Jean
                        </td>
                        <td>
                            ABC-123
                        </td>
                        <td>
                            A102
                        </td>
                        <td>
                            Pants
                        </td>
                        <td>
                            H&M
                        </td>
                        <td>
                            A1
                        </td>
                        <td>
                            100
                        </td>   
                        <td>
                            
                        </td>
                    </tr>

                 
                    <tr class="collapse" id="detail">
                        <td colspan="9">
                            <div class="relative flex w-full pt-3">
                                <div class="pr-6 pt-3 pl-10 pb-6 bg-inherit inline-block relative">
                                    <img src="{{ asset('img/item_1.jpeg') }}" alt="">  
                                    
                                </div>
                                <div class="w-full flex flex-row">
                                    <div class="  w-max">
                                        <div class="flex justify-start pl-6 pt-4">
                                            <p class=" text-sm text-gray-800 inline-block w-12 min-w-max text-left" style="font-family: 'Roboto', sans-serif;">
                                                Color
                                            </p>
                                            <span class="px-3"> : </span>
                                            <p class=" text-sm text-gray-500 inline-block">
                                                Red
                                            </p>
                                        </div>
                                        <div class="flex justify-start pl-6 py-2 ">
                                            <p class=" text-sm text-gray-800 inline-block w-12 min-w-max text-left" style="font-family: 'Roboto', sans-serif;">
                                                Size
                                            </p>
                                            <span class="px-3"> : </span>
                                            <p class=" text-sm text-gray-500 inline-block">
                                                XL
                                            </p>
                                        </div>
                                    </div>
                                    <div class=" pl-8 pt-3.5 w-full">
                                        <table class="secondary-table">
                                            <thead class="secondary-table-thead">
                                                <tr>
                                                    <th class="sec-thead-th" style="padding-top:0.25rem;padding-bottom:0.25rem">
                                                        Floor
                                                    </th>
                                                    <th class="sec-thead-th" style="padding-top:0.25rem;padding-bottom:0.25rem">
                                                        Amount
                                                    </th>
                                                    <th class="sec-thead-th" style="padding-top:0.25rem;padding-bottom:0.25rem">
                                                        Inventory Name
                                                    </th>
                                                    <th class="sec-thead-th" style="padding-top:0.25rem;padding-bottom:0.25rem">
                                                        
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="sec-table-td">
                                                                A1
                                                    </td>
                                                    <td class="sec-table-td">
                                                                90
                                                    </td>   

                                                    <td class="sec-table-td">
                                                        Inventory One
                                                    </td>   
                                                    <td class="pr-10 py-1 text-right w-full">
                                                        <button type="button" title="Add Defect Item" id="defect_button"
                                                            data-bs-toggle="modal" data-bs-target="#defect_item">
                                                            <i class="fal fa-info-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="sec-table-td">
                                                                A1
                                                    </td>
                                                    <td class="sec-table-td">
                                                                90
                                                    </td>   

                                                    <td class="sec-table-td">
                                                        Inventory One
                                                    </td>   
                                                    <td class="pr-10 py-1 text-right w-full">
                                                        <button type="button" title="Add Defect Item" id="defect_button"
                                                            data-bs-toggle="modal" data-bs-target="#defect_item">
                                                            <i class="fal fa-info-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="sec-table-td">
                                                                A1
                                                    </td>
                                                    <td class="sec-table-td">
                                                                90
                                                    </td>   

                                                    <td class="sec-table-td">
                                                        Inventory One
                                                    </td>   
                                                    <td class="pr-10 py-1 text-right w-full">
                                                        <button type="button" title="Add Defect Item" id="defect_button"
                                                            data-bs-toggle="modal" data-bs-target="#defect_item">
                                                            <i class="fal fa-info-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="sec-table-td">
                                                                A1
                                                    </td>
                                                    <td class="sec-table-td">
                                                                90
                                                    </td>   

                                                    <td class="sec-table-td">
                                                        Inventory One
                                                    </td>   
                                                    <td class="pr-10 py-1 text-right w-full">
                                                        <button type="button" title="Add Defect Item" id="defect_button"
                                                            data-bs-toggle="modal" data-bs-target="#defect_item">
                                                            <i class="fal fa-info-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    

                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
  id="defect_item" tabindex="-1" aria-labelledby="defect_item" aria-hidden="true">
  <div class="modal-dialog relative w-auto pointer-events-none" style="max-width:36rem">
    <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">

        <div class="modal-header border-b-0">
            <p class="py-8 px-12 text-base">Add Defect Item</p>
        </div>
        <div class="modal-body px-0">
            <form>
                <div class="flex mx-12">
                    <div class="flex flex-col md:flex-row md:max-w-xl rounded-lg bg-white ">
                        <img class=" w-48 h-48" 
                            src="{{ asset('img/item_1.jpeg') }}" alt="" />
                        <div class="pl-8 flex flex-col justify-start">
                            <h5 class="text-gray-900 text-normal font-medium mb-4">Product Information</h5>
                            <p class="text-gray-700 text-13px mb-2">
                                H&M Jean
                            </p>
                            <p class="text-gray-700 text-13px mb-2">
                                H&M
                            </p>
                            <p class="text-gray-700 text-13px mb-2">
                                Red
                            </p>
                            <p class="text-gray-700 text-13px mb-4">
                                XL
                            </p>
                            <div class="form-group mb-4">
                                <label for="amount" class="form-label label-form">Amount</label>
                                <input type="text" class="form-control input-form mt-2" 
                                        id="amount" placeholder="">
                            </div>
                            <div class="form-group mb-8">
                                <label for="remark" class="form-label label-form">Remark</label>
                                <textarea
                                    name=""
                                    class="mt-2 min-h-[160px] focus:shadow-none focus:outline-none rounded animated-textarea active:shadow-none active:outline-none input-form block"
                                    cols="30"
                                    rows="10"
                                    style="border: 1px solid #e5e7eb"
                                ></textarea>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
            
        <div class="modal-footer-container mr-4">
            <button type="button" class="btn btn-light text-sm" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="px-12 py-2.5 ml-5 mr-0
            bg-black primary-button" data-bs-dismiss="modal">
            Add
            </button>
        
        </div>
    </div>
  </div>
</div>




@endsection

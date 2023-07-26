<!-- add stock to inventory -->
@extends('layouts.main')
@section('title', ' Add Stock')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle pl-4 mb-0">Add Stocks to Inventory</p>
        </div>
        <div class="pt-6 mb-6">
            <div class=" pl-2 grid grid-cols-12 gap-y-1 gap-x-8 mx-2">
                <div class="col-span-3">
                    <label for="" class="form-label label-form">Inventory Number</label>
                </div>
                <div class="col-span-3">
                    <label for="" class="form-label label-form">Inventory Name</label>
                </div>
                <div class="col-span-3">
                    <label for="" class="form-label label-form">Supplier Name</label>
                </div>
                <div class="col-span-3"></div>

                <!-- start row -->
                <div class="col-span-3">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-1"
                               id="" placeholder="Inventory Number">
                    </div>
                </div>
                <div class="col-span-3">
                    <div class="form-group mb-4">

                        <select name="" class=" mt-1 w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2"
                                id=""
                                placeholder="S/M/L">
                        <option value="" disabled selected> Inventory Name</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                    </div>
                </div>
                <div class="col-span-3">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-1"
                               id="" placeholder="Supplier Name">
                    </div>
                </div>
                <div class="col-span-3"></div>
                <!-- end row -->

                
                
            </div>


            

            <!-- start row -->
            <div class=" pl-2 grid grid-cols-12 gap-y-1 gap-x-8 mx-2">
                <div class="col-span-3">
                        <label for="" class="form-label label-form">Item Code</label>
                </div>
                <div class="col-span-3">
                        <label for="" class="form-label label-form">Amount</label>
                </div>
                <div class="col-span-3">
                        <label for="" class="form-label label-form">Floor</label>
                </div>
                <div class="col-span-3">
                        <!-- free space for grid -->
                </div>
                
                <div class="col-span-3">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-1"
                               id="" placeholder="Item Code">
                    </div>
                </div>
                <div class="col-span-3">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-1"
                               id="" placeholder="Amount">
                    </div>
                </div>
                <div class="col-span-3">
                    <div class="form-group mb-4">

                        <input type="text" class="form-control input-form mt-1"
                               id="" placeholder="Floor">
                    </div>
                </div>
                
                <div class="col-span-3">
                    <Button type="button" class="primary-button bg-black mt-2">Add</Button>
                </div>

               
            </div>  
             <div class="">
                    <hr class="my-2 h-0">
                </div>
            
                <!-- end row -->

                
                
            <!-- start row -->
            <div class="w-full pt-2">
                <table class="secondary-table">
                    <thead class="secondary-table-thead">
                        <tr>
                            <th class="sec-thead-th">
                                Item Code
                            </th>
                            <th class="sec-thead-th">
                                Product Name
                            </th>
                            <th class="sec-thead-th">
                                Seires
                            </th>
                            <th class="sec-thead-th">
                                Brand
                            </th>
                            <th class="sec-thead-th">
                                Sub Category
                            </th>
                            <th class="sec-thead-th">
                                Color
                            </th>
                            <th class="sec-thead-th">
                                Size
                            </th>
                            <th class="sec-thead-th">
                                Location
                            </th>
                            <th class="sec-thead-th">
                                Amount
                            </th>
                            <th class="sec-thead-th">
                                
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="sec-table-td">
                                ABC-123
                            </td>
                            <td class="sec-table-td">
                                H&MA10 Jean
                            </td>
                            <td class="sec-table-td">
                                A10
                            </td>
                            <td class="sec-table-td">
                                H&M
                            </td>
                            <td class="sec-table-td">
                                Pants
                            </td>
                            <td class="sec-table-td">
                                Red
                            </td>
                            <td class="sec-table-td">
                                M
                            </td>
                            <td class="sec-table-td">
                                A1
                            </td>
                            <td class="sec-table-td">
                                100
                            </td>
                            <td class="sec-table-td">
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









           
            
            <!-- end row -->

            
            
            <div class="flex justify-end pb-4 mt-12">
                <button type="button" class="primary-button bg-black">
                            Create
                </button>
            </div>

        </div>
        
        
    </div>



@endsection

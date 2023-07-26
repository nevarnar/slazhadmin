@extends('layouts.main')
@section('title', ' Home Page')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Home Page Management</p>
        </div>
        <div class="pt-6 mb-6">
            <div class=" grid grid-cols-9 gap-y-2 gap-x-8 mx-2 pb-3">
                <div class="col-span-2">
                    <label for="" class="label-form">Section Name</label>
                </div>
                <div class="col-span-2">
                    <label for="" class="label-form">UI Style</label>
                </div>
                <div class="col-span-2">
                    <label for="" class="label-form">Endless Scroll / Each Item</label>
                </div>
                <div class="col-span-3 text-right">
                    <Button class="primary-button bg-black">Add</Button>
                </div>

                <!-- start row -->
                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <input type="text" class="form-control input-form "
                               id="" placeholder="">
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <select name="" class="w-full text-xs border rounded-sm bg-white py-1.5" id=""
                                        placeholder="...">
                                    <option value="">Style</option>
                                    <option value="1">New One</option>
                        </select>
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <select name="" class="w-full text-xs border rounded-sm bg-white py-1.5" id=""
                                        placeholder="...">
                                    <option value="">Each Item</option>
                                    <option value="1">Endless Scroll</option>
                        </select>
                    </div>
                </div>
                <div class="col-span-3">
                     <!-- free space for grid  -->
                </div>
                <!-- end row -->
                
            </div>

    
            <div class="flex justify-start mt-2">
                <div>
                    <p class="page-tittle text-sm pl-2">Editorial Choice(Choose 6 Styles)</p>
                </div>
            </div>

            <!-- start row -->
            <div class="flex flex-row">
                <div class="basis-7/12">
                    <div class="form-group mb-4 ml-2">
                        <div class="inline-block" style="width:calc( 100% - 136px)">
                            <input type="text" class="form-control input-form mt-2"
                               id="" placeholder="Quantity">
                        </div>
                        <div class="inline-block mt-2 mx-3" style="width:107px">
                            <button class="primary-button bg-black">Search</button>
                        </div>
                    </div>

                    <table class="inline-block table-auto secondary-table">
                        <thead class="secondary-table-thead">
                            <tr>
                                <th class="sec-thead-th">
                                    Item SKU
                                </th>
                                <th class="sec-thead-th">
                                    Sub Category
                                </th>
                                <th class="sec-thead-th">
                                    Brand
                                </th>
                                <th class="sec-thead-th">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sec-table-td">
                                    ABC-Black-HM-123
                                </td>
                                <td class="sec-table-td">
                                    Pants
                                </td>
                                <td class="sec-table-td">
                                    H&M
                                </td>
                                    
                                <td class="sec-table-td">
                                    <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                        <i class="fal fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="sec-table-td">
                                    ABC-Black-HM-123
                                </td>
                                <td class="sec-table-td">
                                    Pants
                                </td>
                                <td class="sec-table-td">
                                    H&M
                                </td>
                                    
                                <td class="sec-table-td">
                                    <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                        <i class="fal fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="sec-table-td">
                                    ABC-Black-HM-123
                                </td>
                                <td class="sec-table-td">
                                    Pants
                                </td>
                                <td class="sec-table-td">
                                    H&M
                                </td>
                                    
                                <td class="sec-table-td">
                                    <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                        <i class="fal fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="sec-table-td">
                                    ABC-Black-HM-123
                                </td>
                                <td class="sec-table-td">
                                    Pants
                                </td>
                                <td class="sec-table-td">
                                    H&M
                                </td>
                                    
                                <td class="sec-table-td">
                                    <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                        <i class="fal fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td class="sec-table-td">
                                    ABC-Black-HM-123
                                </td>
                                <td class="sec-table-td">
                                    Pants
                                </td>
                                <td class="sec-table-td">
                                    H&M
                                </td>
                                    
                                <td class="sec-table-td">
                                    <button type="button" class="btn-clear" title="Delete" id="delete-button">
                                        <i class="fal fa-times"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                
                <div class="basis-5/12 w-full block relative mt-2">
                    <div class="flex flex-col md:flex-row md:max-w-xl bg-white">
                        <img class=" w-44 h-48 rounded-md
                            " src="https://mdbootstrap.com/wp-content/uploads/2020/06/vertical.jpg" alt="" />

                        <div class="p-6 flex flex-col justify-start">
                            <p class="text-gray-900 text-sm font-medium mb-2">Item Detail</p>
                            <div class="flex flex-row w-72">
                                <div class="flex-col basis-1/3">
                                    <p class="card-pri-text">Item SKU</p>
                                </div>
                                <div class="flex-col basis-2/3 ml-8">
                                    <p class="card-sec-text">
                                        ABC-Black-H&M-13
                                    </p>
                                </div>
                            </div>
                            <div class="flex w-72 flex-row">
                                    <div class="flex-col basis-1/3">
                                        <p class="card-pri-text">Sub Category</p>
                                    </div>
                                    <div class="flex-col basis-2/3 ml-8">
                                        <p class="card-sec-text">
                                            Pants
                                        </p>
                                    </div>
                            </div>
                            <div class="flex w-72 flex-row">
                                    <div class="flex-col basis-1/3">
                                        <p class="card-pri-text">
                                            Brand
                                        </p>
                                    </div>
                                    <div class="flex-col basis-2/3 ml-8">
                                        <p class="card-sec-text">
                                            H&M-13
                                        </p>
                                    </div>
                            </div>
                            <div class="flex w-72 flex-row">
                                    <div class="flex-col basis-1/3">
                                        <p class="card-pri-text">
                                            Color
                                        </p>
                                    </div>
                                    <div class="flex-col basis-2/3 ml-8">
                                        <p class="card-sec-text">
                                            Golden yellow white
                                        </p>
                                    </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>
                <!-- end row -->

                
                
            <!-- start row -->
            <div class="">
                    <hr class="my-2 h-0.5">
            </div>
            <!-- end row -->

            <!-- start -->
            <div class="col-span-9">
                <div class="block w-full mb-8">
                    <table class="secondary-table w-full">
                        <thead class="secondary-table-thead">
                            <tr>
                                <th class="sec-thead-th">
                                    Section Name
                                </th>
                                <th class="sec-thead-th">
                                    Description
                                </th>
                                <th class="sec-thead-th">
                                    Category
                                </th>
                                <th class="sec-thead-th">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sec-table-td">
                                    1st Section
                                </td>
                                <td class="sec-table-td">
                                    Editorial
                                </td>
                                <td class="sec-table-td">
                                    Style
                                </td>
                                <td class="sec-table-td text-right">
                                    <button type="button" title="" class="mx-2" id="">
                                        <i class="fas fa-th-large"></i>
                                    </button>
                                    <button type="button" title="" class="mx-2" id="">
                                        <i class="fal fa-file-edit"></i>
                                    </button>
                                    <button type="button" title="" class="mx-2" id="">
                                        <i class="fal fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- end -->
            

        </div>
        
        
    </div>



@endsection

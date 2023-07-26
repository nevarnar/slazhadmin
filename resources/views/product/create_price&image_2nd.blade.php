@extends('layouts.main')
@section('title', ' CreateOrUpdate Product')
@section('content')

    <div class="inner-main-container">
        <div class=" relative flex justify-between pb-3">
            <div>

                <p class="page-tittle">Create Product</p>
            </div>
            <div>
                <button type="button" class="px-6 py-2.5 mr-5
                    bg-black text-white font-medium text-xs leading-tight
                    hover:bg-black focus:bg-black focus:outline-none focus:ring-0
                    active:bg-black transition duration-150 ease-in-out">
                    Publish
                </button>
            </div>
        </div>

        <div class="block pb-8">
            <table class=" w-full">
                <thead class="bgcolor-table-header">
                <tr>
                    <th class="px-5 py-2 text-xs capitalize text-gray-500 text-left">
                        ID
                    </th>
                    <th class="px-6 py-2 text-xs capitalize text-gray-500">
                        Image
                    </th>
                    <th class="px-6 py-2 text-xs capitalize text-gray-500">
                        Color
                    </th>
                    <th class="px-6 py-2 text-xs capitalize text-gray-500">
                        Size
                    </th>
                    <th class="px-6 py-2 text-xs capitalize text-gray-500">
                        SKU
                    </th>
                    <th class="px-6 py-2 text-xs capitalize text-gray-500">
                        Pricing
                    </th>
                    <th class="px-6 py-2 text-xs capitalize text-gray-500">
                        Action
                    </th>
                </tr>
                </thead>

                <tbody class="bg-white">

                <tr class="whitespace-nowrap table-border-bottom">
                    <td class="px-5 py-2 text-black-500 text-table text-left">
                        1
                    </td>
                    <td class="px-5 py-2">
                        <div class="custom-file-input flex justify-center p-0 border-none">
                            <label for="input-test" class="text-center border-none p-0" style="border:none;padding:0;">
                                <div class="item-img-container">
                                    <img src="{{ asset('img/item_1.jpeg') }}" alt="">
                                </div>
                                <input type="file" name="" id="input-test" class="">
                            </label>
                        </div>
                    </td>
                    <td class="px-5 py-2">
                        <div class=" text-gray-600 text-table">
                            White
                        </div>
                    </td>
                    <td class="px-5 py-2">
                        <div class=" text-gray-600 text-table">
                            16
                        </div>
                    </td>
                    <td class="px-5 py-2">
                        <div class=" text-gray-600 text-table">
                            ABC-112-White
                        </div>
                    </td>
                    <td class="px-5 py-2">
                        <div class=" text-gray-600 text-table">
                            55000 MMKs
                        </div>
                    </td>
                    <td class="px-5 py-2 text-center">

                        <button type="button" class="btn-clear" title="Add Price" id="add_price"
                                data-bs-toggle="modal" data-bs-target="#add_price_modal">
                                <i class="fal fa-gift fw300" style="color:#68728c;"></i>
                        </button>
                        <button type="button" class="btn-clear" title="Add Price" id="add_special_price"
                                data-bs-toggle="modal" data-bs-target="#add_special_price_modal">
                                <i class="fal fa-plus fw300" style="color:#68728c;"></i>
                        </button>
                    </td>
                </tr>

                <tr class="whitespace-nowrap table-border-bottom">
                    <td class="px-5 py-2 text-black-500 text-table text-left">
                        2
                    </td>
                    <td class="px-5 py-2">
                        <div class="custom-file-input flex justify-center p-0 border-none">
                            <label for="input-test" class="text-center border-none p-0" style="border:none;padding:0;">
                                <div class="item-img-container">
                                    <img src="{{ asset('img/item_1.jpeg') }}" alt="">
                                </div>
                                <input type="file" name="" id="input-test" class="">
                            </label>
                        </div>
                    </td>
                    <td class="px-5 py-2">
                        <div class=" text-gray-600 text-table">
                            Black
                        </div>
                    </td>
                    <td class="px-5 py-2">
                        <div class=" text-gray-600 text-table">
                            16
                        </div>
                    </td>
                    <td class="px-5 py-2">
                        <div class=" text-gray-600 text-table">
                            ABC-112-Black
                        </div>
                    </td>
                    <td class="px-5 py-2">
                        <div class=" text-gray-600 text-table">
                            43000 MMKs
                        </div>
                    </td>
                    <td class="px-5 py-2 text-center">
                    <button type="button" class="btn-clear" title="Add Price" id="add_price"
                                data-bs-toggle="modal" data-bs-target="#add_price_modal">
                                <i class="fal fa-gift fw300" style="color:#68728c;"></i>
                        </button>
                        <button type="button" class="btn-clear" title="Add Price" id="add_special_price"
                                data-bs-toggle="modal" data-bs-target="#add_special_price_modal">
                                <i class="fal fa-plus fw300" style="color:#68728c;"></i>
                        </button>
                    </td>
                </tr>
                <tr class="whitespace-nowrap table-border-bottom">
                    <td class="px-5 py-2 text-black-500 text-table text-left">
                        3
                    </td>
                    <td class="px-5 py-2">
                        <div class="custom-file-input flex justify-center p-0 border-none">
                            <label for="input-test" class="text-center border-none p-0" style="border:none;padding:0;">
                                <div class="item-img-container">
                                    <img src="{{ asset('img/item_1.jpeg') }}" alt="">
                                </div>
                                <input type="file" name="" id="input-test" class="">
                            </label>
                        </div>
                    </td>
                    <td class="px-5 py-2">
                        <div class=" text-gray-600 text-table">
                            Red
                        </div>
                    </td>
                    <td class="px-5 py-2">
                        <div class=" text-gray-600 text-table">
                            16
                        </div>
                    </td>
                    <td class="px-5 py-2">
                        <div class=" text-gray-600 text-table">
                            ABC-112-Red
                        </div>
                    </td>
                    <td class="px-5 py-2">
                        <div class=" text-gray-600 text-table">
                            25000 MMKs
                        </div>
                    </td>
                    <td class="px-5 py-2 text-center">
                    <button type="button" class="btn-clear" title="Add Price" id="add_price"
                                data-bs-toggle="modal" data-bs-target="#add_price_modal">
                                <i class="fal fa-gift fw300" style="color:#68728c;"></i>
                        </button>
                        <button type="button" class="btn-clear" title="Add Price" id="add_special_price"
                                data-bs-toggle="modal" data-bs-target="#add_special_price_modal">
                                <i class="fal fa-plus fw300" style="color:#68728c;"></i>
                        </button>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>

<!--Add Price Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    id="add_price_modal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div class="modal-content border-none shadow-lg relative flex flex-col
            w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">

            <div class="modal-header border-b-0 mx-4">
                <div class="flex justify-between pr-0" >
                    <p class="pt-8 px-8 text-base">Add New Price</p>
                    <p class="pt-8 px-8 text-gray-600 font-light text-sm">Item : Code</p>
                </div>
            </div>
            <div class="modal-body px-2 mx-4">
                <form>
                    <div class="block p-6 rounded-lg bg-white">
                        <div class="flex flex-row">
                            <div class=" basis-full">
                                <div class="form-group mb-6">
                                    <label for="name" class="form-label label-form">Price</label>
                                    <input type="text"
                                        class="form-control input-form mt-3 focus:shadow-none
                                        block w-full px-3 py-1.5 text-gray-700
                                        bg-white bg-clip-padding border border-solid border-gray-300
                                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        id="name" placeholder="">
                                </div>
                            </div>
                        </div>




                    </div>
                </form>
            </div>

            <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-start px-8 mx-4 mt-2 pt-0 pb-8">
                <button type="button" class="px-6 py-2.5 mr-5 bg-black text-white
                font-medium text-sm leading-tight shadow-md hover:bg-black
                focus:bg-black focus:outline-none focus:ring-0 rounded-sm
                active:bg-black  transition duration-150 ease-in-out" data-bs-dismiss="modal">
                    Add
                </button>
                <button type="button" class="btn text-sm" data-bs-dismiss="modal">Cancel</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    id="add_special_price_modal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">

            <div class="modal-header border-b-0">
                <div class="flex justify-between pr-0" >
                    <p class="pt-8 px-8 text-base">Add Special Price</p>
                    <p class="pt-8 px-8 text-gray-600 font-light text-sm">Item : Code</p>
                </div>
            </div>
            <div class="modal-body px-2">
                <form>
                    <div class="block p-6 rounded-lg bg-white">
                        <div class="flex flex-row">
                            <div class="basis-1/2 pr-2">
                                <div class="form-group mb-6">
                                    <label for="name" class="form-label label-form">Promotion Name</label>
                                    <input type="text"
                                            class="form-control input-form mt-3 focus:shadow-none
                                            block w-full px-3 py-1.5 text-gray-700
                                            bg-white bg-clip-padding border border-solid border-gray-300
                                            rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                            id="name" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row flex-wrap">
                            <div class="basis-1/2 pr-2">
                                <div class="form-group mb-6">
                                    <label for="price" class="form-label label-form">Price</label>
                                    <input type="text"
                                        class="form-control input-form mt-3 focus:shadow-none
                                        block w-full px-3 py-1.5 text-gray-700
                                        bg-white bg-clip-padding border border-solid border-gray-300
                                        rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        id="price" placeholder="">
                                </div>
                            </div>
                            <div class="basis-1/2 pl-2">
                                <div class="form-group mb-6">
                                    <label for="amount" class="form-label label-form">Amount</label>
                                    <input type="text"
                                            class="form-control input-form mt-3 focus:shadow-none
                                            block w-full px-3 py-1.5 text-gray-700
                                            bg-white bg-clip-padding border border-solid border-gray-300
                                            rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                            id="amount" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row">
                            <div class="basis-1/2 pr-2">
                                <div class="form-group mb-6">
                                    <label for="category" class="form-label label-form">Promotion Category</label>
                                    <input type="text"
                                            class="form-control input-form mt-3 focus:shadow-none
                                            block w-full px-3 py-1.5 text-gray-700
                                            bg-white bg-clip-padding border border-solid border-gray-300
                                            rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                            id="category" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row">
                            <div class="basis-1/2 pr-2">
                                <div class="form-group mb-6">
                                    <label for="category" class="form-label label-form">From</label>
                                    <input type="text" class="pickdate input-form border w-full text-gray-700 border-1 focus:outline-none">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-row">
                            <div class="basis-1/2 pr-2">
                                <div class="form-group mb-6">
                                    <label for="category" class="form-label label-form">To</label>
                                    <input type="text" class="pickdate input-form border w-full text-gray-700 border-1 focus:outline-none">
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-start px-8 pt-0 pb-8">
                <button type="button" class="px-6 py-2.5 mr-5 bg-black text-white
                font-medium text-sm leading-tight shadow-md hover:bg-black hover:shadow-lg
                focus:bg-black focus:shadow-lg focus:outline-none focus:ring-0
                active:bg-black active:shadow-lg transition duration-150 ease-in-out" data-bs-dismiss="modal">
                    Add
                </button>
                <button type="button" class="btn text-sm" data-bs-dismiss="modal">Cancel</button>

            </div>
        </div>
    </div>
</div>


@endsection

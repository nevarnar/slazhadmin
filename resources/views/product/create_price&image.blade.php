@extends('layouts.main')
@section('title', ' CreateOrUpdate Product')
@section('content')

    <div class="inner-main-container">
        <div>

        </div>
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
                        <div class="form-check form-switch inline-block align-middle">
                                <input class="form-check-input switch " type="checkbox" role="switch" id="flexSwitchCheckDefault56">
                            </div>
                        <button type="button" class="btn-clear" title="Edit" id="edit-button">
                            <a class="a-clear" href="#">
                                <i class="fal fa-file-edit fw300" style="color:#68728c;"></i>
                            </a>
                        </button>
                        <button type="button" class="btn-clear" title="Edit" id="edit-button">
                            <a class="a-clear" href="#">
                                <i class="fal fa-trash fw300" style="color:#68728c;"></i>
                            </a>
                        </button>
                    </td>
                </tr>
                <tr class="whitespace-nowrap table-border-bottom">
                    <td class="px-5 py-2 text-black-500 text-table text-left">
                        2
                    </td>
                    <td class="px-5 py-2">
                        <div class="custom-file-input flex justify-center">
                            <label for="input_file" class="text-center">
                                Browse
                                <input type="file" name="" id="input_file" class="">
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
                        <div class="form-check form-switch inline-block align-middle">
                                <input class="form-check-input switch " type="checkbox" role="switch" id="flexSwitchCheckDefault56">
                            </div>
                        <button type="button" class="btn-clear" title="Edit" id="edit-button">
                            <a class="a-clear" href="#">
                                <i class="fal fa-file-edit fw300" style="color:#68728c;"></i>
                            </a>
                        </button>
                        <button type="button" class="btn-clear" title="Edit" id="edit-button">
                            <a class="a-clear" href="#">
                                <i class="fal fa-trash fw300" style="color:#68728c;"></i>
                            </a>
                        </button>
                    </td>
                </tr>
                <tr class="whitespace-nowrap table-border-bottom">
                    <td class="px-5 py-2 text-black-500 text-table text-left">
                        3
                    </td>
                    <td class="px-5 py-2">
                        <div class="custom-file-input flex justify-center">
                            <label for="input_file" class="text-center">
                                Browse
                                <input type="file" name="" id="input_file" class="">
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
                        <div class="form-check form-switch inline-block align-middle">
                                <input class="form-check-input switch " type="checkbox" role="switch" id="flexSwitchCheckDefault56">
                            </div>
                        <button type="button" class="btn-clear" title="Edit" id="edit-button">
                            <a class="a-clear" href="#">
                                <i class="fal fa-file-edit fw300" style="color:#68728c;"></i>
                            </a>
                        </button>
                        <button type="button" class="btn-clear" title="Edit" id="edit-button">
                            <a class="a-clear" href="#">
                                <i class="fal fa-trash fw300" style="color:#68728c;"></i>
                            </a>
                        </button>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>



@endsection

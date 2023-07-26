@extends('layouts.main')
@section('title', ' Edit Size Chart')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Edit Size Chart</p>
        </div>
        <div class="pt-6 mb-6">
            <div class=" grid grid-cols-3 gap-y-2 gap-x-8 mx-2">
                <!-- start row -->
                <div class="">
                    <div class="form-group mb-4">
                        <label for="name" class="form-label label-form">Name</label>
                        <input type="text" class="form-control input-form mt-3
                                block w-full px-3 py-1.5 text-gray-700
                                bg-white bg-clip-padding border border-solid border-gray-300
                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                               id="name" placeholder="">
                    </div>
                </div>
                <div class="">
                    <div class="form-group mb-4">
                        <label for="brand" class="form-label label-form">Brand</label>
                        <input type="text" class="form-control input-form mt-3
                                block w-full px-3 py-1.5 text-gray-700
                                bg-white bg-clip-padding border border-solid border-gray-300
                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                               id="brand" placeholder="">
                    </div>
                </div>
                <div class="">
                    <!-- 3rd grid space -->
                </div>
                <!-- end row -->
                <label for="engName" class="form-label label-form">Contact Name</label>
                <label for="engName" class="form-label label-form">Size</label>
                <div></div>
                <!-- start row -->
                <div class="">
                    <div class="form-group mb-4">
                        <select name="" class="w-full text-xs border text-gray-500 rounded-sm bg-white py-1.5 mt-2" id=""
                                placeholder="...">
                            <option value=""></option>
                            <option value="1">New One</option>
                        </select>
                    </div>
                </div>
                <div class="">
                    <div class="form-group mb-4">
                        
                        <select name="" class="w-full text-gray-500 text-xs border rounded-sm bg-white py-1.5 mt-2"
                                id=""
                                placeholder="S/M/L">
                            <option value="" disabled selected> S / M / L</option>
                            <option value="1">Small</option>
                            <option value="1">Medium</option>
                            <option value="1">Large</option>
                        </select>
                        
                    </div>
                </div>
                <div class="">
                    <!-- 3rd grid space -->
                </div>
                <!-- end row -->

                
                <div class="col-span-3 mb-3">
                    <label class="form-label label-form text-sm">Unit</label>
                </div>

                <!-- start row -->
                <div class="">
                    <div class="form-group mb-4">
                        <label for="height" class="form-label label-form">Height</label>
                        <input type="text" class="form-control input-form mt-3
                                block w-full px-3 py-1.5 text-gray-700
                                bg-white bg-clip-padding border border-solid border-gray-300
                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                               id="height" placeholder="">
                        <!-- <span class="text-xs text-gray-300 absolute" 
                        style="top:22px; right:22px">
                        mm
                    </span> -->
                    </div>
                </div>
                <div class=" col-span-2">
                    <p class="text-xs mt-11 text-gray-500">mm</p>
                    <!-- two grid space -->
                </div>
                <!-- end row -->

                <!-- start row -->
                <div class="">
                    <div class="form-group mb-4">
                        <label for="hip" class="form-label label-form">Hip</label>
                        <input type="text" class="form-control input-form mt-3
                                block w-full px-3 py-1.5 text-gray-700
                                bg-white bg-clip-padding border border-solid border-gray-300
                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                               id="hip" placeholder="">
                        <!-- <span class="text-xs text-gray-300 absolute" 
                        style="top:22px; right:22px">
                        mm
                    </span> -->
                    </div>
                </div>
                <div class=" col-span-2">
                    <p class="text-xs mt-11 text-gray-500">mm</p>
                    <!-- two grid space -->
                </div>
                <!-- end row -->

                <!-- start row -->
                <div class="">
                    <div class="form-group mb-4">
                        <label for="legs" class="form-label label-form">Legs</label>
                        <input type="text" class="form-control input-form mt-3
                                block w-full px-3 py-1.5 text-gray-700
                                bg-white bg-clip-padding border border-solid border-gray-300
                                rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:shadow-none focus:outline-none"
                               id="legs" placeholder="">
                        <!-- <span class="text-xs text-gray-300 absolute" 
                        style="top:22px; right:22px">
                        mm
                    </span> -->
                    </div>
                </div>
                <div class=" col-span-2">
                    <p class="text-xs mt-11 text-gray-500">mm</p>
                    <!-- two grid space -->
                </div>
                



                <div>
                    <button type="button" class="px-6 py-2.5 mr-5
                    bg-black text-white font-medium text-xs leading-tight rounded-sm
                    hover:bg-black focus:bg-black focus:outline-none focus:ring-0
                    active:bg-black transition duration-150 ease-in-out" data-bs-dismiss="modal">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>



@endsection

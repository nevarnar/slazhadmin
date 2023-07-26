@extends('layouts.main')
@section('title', ' CreateOrUpdate Purchase Order')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Create Admins</p>
        </div>
        <div class="pt-6 mb-6">
            <div class="grid grid-cols-9 gap-y-2 gap-x-8 mx-2">
                <div class="col-span-2">
                    <label for="" class="label-form">Admin Name</label>
                </div>
                <div class="col-span-7">
                    <!-- free space for grid -->
                </div>

                <!-- start row -->
                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <input type="text" class="mt-2 input-form"
                               id="" placeholder="Name">
                    </div>
                </div>
                <div class="col-span-7">
                     <!-- free space for grid  -->
                </div>
                <!-- end row -->

                <div class="col-span-2">
                    <label for="" class="label-form">Password</label>
                </div>
                <div class="col-span-7">
                     <!-- free space for grid  -->
                </div>
                <div class="col-span-2">
                    <div class="form-group mb-4">
                        <input type="password" class="form-control input-form mt-2"
                               id="password" placeholder="password">
                    </div>
                </div>
                <div class="col-span-7">
                     <!-- free space for grid  -->
                </div>
                
                <div class=" col-span-9">
                    <label for="" class="label-form">Category</label>
                </div>
                <div class=" col-span-9">
                    <div class="mb-2">
                        <label for="" class="label-form">
                            <input type="checkbox">
                            Product Information Management
                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="" class="label-form">
                            <input type="checkbox">
                            Inventory Management
                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="" class="label-form">
                            <input type="checkbox">
                            Promotion Management
                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="" class="label-form">
                            <input type="checkbox">
                            Customer Support Management
                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="" class="label-form">
                            <input type="checkbox">
                            Order Management
                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="" class="label-form">
                            <input type="checkbox">
                            Admin Management
                        </label>
                    </div>




                    
                </div>
            </div>



            


            


            

        </div>


    </div>



@endsection

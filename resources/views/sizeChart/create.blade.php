@extends('layouts.main')
@section('title', ' Create Size Chart')
@section('content')
<!-- <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script> -->
<script src="https://cdn.tiny.cloud/1/q3izmtpr7smpz3pgax645juzvzebttbz7n4lr0zv0oamhhe2/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    
    <div class="inner-main-container">
        <div>
            <p class="page-tittle">
                Create Size Chart
            </p>
        </div>
        <div class="pt-6 mb-6">
            <div class="grid grid-cols-8 gap-x-8 mx-2">
                <!-- start row -->
                <div class="col-span-4">
                    <label for="" class="form-label label-form"
                        >Size Guide Name</label
                    >
                </div>
                <div class="col-span-4"></div>

                
                <div class="col-span-2">
                    <div class="form-group mb-6">
                        <input
                            type="text"
                            class="form-control input-form mt-2"
                            id=""
                            placeholder="Size Guide Name"
                        />
                    </div>
                </div>
                <div class="col-span-6"></div>
                <!-- end row -->
                <div class="col-span-8">
                    <p class="page-tittle">
                        Add Size Chart
                    </p>
                </div>


                

                <!-- start row -->
                <div class=" col-span-2">
                    <label for="" class="form-label label-form"
                        >Type</label
                    >
                </div>
                <div class=" col-span-6"></div>

                <div class=" col-span-2 mb-4">
                    <select name=""
                        class="w-full text-gray-500 text-xs border rounded-[5px] bg-white px-3 py-2 mt-2"
                            id=""
                            placeholder="Public"
                        >
                            <option value="private" selected>Private</option>
                            <option value="public">Public</option>
                            <option value="limited">Limited</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <button class="primary-button btn-clear mt-2">
                        Add 
                    </button>
                </div>
                <div class=" col-span-4"></div>
                

                <div class=" col-span-8 w-full pt-2 mb-6">
                    <table class="secondary-table">
                        <thead class="secondary-table-thead">
                            <tr>
                                <th class="sec-thead-th"></th>
                                <th class="sec-thead-th">Sizes</th>
                                <th class="sec-thead-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sec-table-td">
                                    1
                                </td>
                                <td class="sec-table-td">
                                    UK
                                </td>
                                <td class="sec-table-td">
                                    <button class="primary-font text-sm"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal"
                                        type="button"
                                        title="Edit"
                                        id="edit_button"
                                    >
                                        <i class="fal fa-edit"></i>
                                    </button>
                                    <button class="primary-font text-sm"
                                        type="button"
                                        title="Delete"
                                        id="delete_button"
                                    >
                                        <i class="fal fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class=" col-span-8">
                    <hr class="my-2 h-0.5" />
                </div>
                <!-- end row -->

                
            </div>


            

            <div class="flex justify-end pb-4">
                <button
                    type="button"
                    class="primary-button bg-black"
                >
                    create
                </button>
            </div>
        </div>





        <div ref="modal" class="modal fade primary-modal"
            id="exampleModal" tabindex="-1" aria-labelledby="createModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-box" style="max-width:60%">
                <div class="modal-content content-modal" style="width:auto">
                    
                    <form>
                        <div class="modal-body px-2 pt-3 mx-2">
                            <div class="block p-6 pt-3 rounded-lg bg-white">
                                <textarea>
                                    Type Here!
                                </textarea>
                                
                            </div>
                        </div>

                        <div class="modal-footer modal-btn-container">
                            <button
                                type="button"
                                class="primary-button bg-black"
                                data-bs-dismiss="modal"
                            >
                                Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
         tinymce.init({
      selector: 'textarea',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | bold italic underline strikethrough | link image media table | blocks fontfamily fontsize | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
    </script>


@endsection

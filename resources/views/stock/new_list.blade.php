@extends('layouts.main')
@section('title', ' Invoice List')
@section('content')

    <div class="inner-main-container">
        <div>
            <p class="page-tittle">Invoice List</p>
        </div>
        <div class=" relative flex justify-between">
            <div class="mb-2">
                <div class="form-check inline-block ml-3 mr-2">
                    <input class="form-check-input input-check float-center" type="checkbox" value="">
                </div>
                <div class="inline-block mx-1">
                    <select name="" class="w-full text-gray-500 text-xs border rounded-sm bg-white px-3 py-1.5 mt-2"
                                id=""
                                placeholder="S/M/L">
                        <option value="" disabled selected> Inventory</option>
                        <option value="1">Inventory 1</option>
                        <option value="2">Inventory 2</option>
                        <option value="3">Inventory 3</option>
                    </select>
                </div>
                <div class="inline-block ml-1 mr-1.5">
                    <select name="" class="w-full text-gray-500 text-xs border rounded-sm bg-white px-3 py-1.5 mt-2" id=""
                        placeholder="S/M/L">
                        <option value="" disabled selected> Date</option>
                        <option value="1">Small</option>
                        <option value="1">Medium</option>
                        <option value="1">Large</option>
                    </select>
                </div>

               
                
            </div>

            <div>
                
            </div>
        </div>
        <div class="block pb-8">
            <table class="primary-table">
                <thead>
                    <tr>
                        <th>
                            ID
                        </th>
                        <th>
                            Invoice Id
                        </th>
                        <th>
                            Date
                        </th>
                        <th>
                            Supplier
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
                        <td>
                            10211
                        </td>
                        <td>
                            3 May 2022
                        </td>
                        <td>
                            Daw win
                        </td>
                         
                        <td>
                            <button type="button" title="Detail" id="detail-button">
                                Detail
                            </button>
                        </td>
                    </tr>

                 
                    
                    

                </tbody>
            </table>
        </div>
    </div>




@endsection

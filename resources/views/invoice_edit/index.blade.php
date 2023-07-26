@extends('layouts.main')
@section('title', ' Invoice Edit')
@section('content')

<?php
    $parameter = request()->route()->parameters;
    $sub_product_id = $parameter['sub_product_id'];
    $floor_id = $parameter['floor_id']; 
    ?>
    <invoice-edit subproductid={{$sub_product_id}} floorid={{$floor_id}} />

@endsection

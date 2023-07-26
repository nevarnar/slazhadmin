<!-- accept inventory -->
@extends('layouts.main')
@section('title', ' Warehouse Transfer')
@section('content')

@php
    $auth = [ 'isAdmin'=> Auth::user()->isAdmin(),'inventory_id'=>Auth::user()->inventory_id ];
@endphp
    <inventory-transfer-detail :auth-user={{ json_encode($auth) }} />



@endsection

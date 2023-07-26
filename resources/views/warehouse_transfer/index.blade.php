@extends('layouts.main')
@section('title', ' Warehouse Transfer List')
@section('content')


@php
$auth = [ 'isAdmin'=> Auth::user()->isSuperAdmin(),'isInventory'=> Auth::user()->hasPermission('inventory-management'),'inventory_id'=>Auth::user()->inventory_id ];
@endphp
    <inventory-transfer-lists :auth-user={{ json_encode($auth) }} />

<!-- inventory movement list -->







@endsection

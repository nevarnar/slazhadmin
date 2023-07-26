@extends('layouts.main')
@section('title', ' Invoice List')
@section('content')
@php

    $auth = [ 'isAdmin'=> Auth::user()->isSuperAdmin(),'isInventory'=> Auth::user()->hasPermission('inventory-management'),'inventory_id'=>Auth::user()->inventory_id ];
@endphp
    <invoice-lists :auth-user={{ json_encode($auth) }} />




@endsection

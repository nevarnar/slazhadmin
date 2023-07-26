<!-- add stock to inventory -->
@extends('layouts.main')
@section('title', ' Add Stock to Inventory')
@section('content')
@php

$auth = [ 'isAdmin'=> Auth::user()->isSuperAdmin(),'isInventory'=> Auth::user()->hasPermission('inventory-management'),'inventory_id' => Auth::user()->inventory_id];
@endphp


<stock-create :auth-user={{ json_encode($auth) }} />

@endsection

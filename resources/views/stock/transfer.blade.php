<!-- accept inventory -->
@extends('layouts.main')
@section('title', ' Warehouse Transfer')
@section('content')
    @php
    $auth = [ 'isAdmin'=> Auth::user()->isSuperAdmin(),'isInventory'=> Auth::user()->hasPermission('inventory-management'),'inventory_id' => Auth::user()->inventory_id,'transaction_id'=>$transaction_id];
@endphp
<inventory-trasfer-create :auth-user={{ json_encode($auth) }} />




@endsection

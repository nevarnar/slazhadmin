@extends('layouts.main')
@section('title', ' Stock List')
@section('content')

@php
    $auth = [ 'isAdmin'=> Auth::user()->isSuperAdmin(),'isInventory'=> Auth::user()->hasPermission('inventory-management'),'inventory_id' => Auth::user()->inventory_id,  ];
@endphp
<stock-lists  :auth-user= {{json_encode($auth)}} />




@endsection

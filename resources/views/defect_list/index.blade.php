@extends('layouts.main')
@section('title', ' Defect List')
@section('content')

@php
    $auth = [ 'isAdmin'=> Auth::user()->isSuperAdmin(),'isInventory'=> Auth::user()->hasPermission('inventory-management'),'inventory_id' => Auth::user()->inventory_id, 'defectConfirm' => false ];
@endphp
<defect-lists :auth-user={{ json_encode($auth) }}  />








@endsection

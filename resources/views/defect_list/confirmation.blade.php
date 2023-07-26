@extends('layouts.main')
@section('title', ' Defect Confirmation List')
@section('content')

@php
    $auth = [ 'isAdmin'=> Auth::user()->isSuperAdmin(),'isInventory'=> Auth::user()->hasPermission('inventory-management'),'inventory_id' => Auth::user()->inventory_id, 'defectConfirm' => true ];
@endphp
<defect-lists :auth-user={{ json_encode($auth) }}  />




@endsection

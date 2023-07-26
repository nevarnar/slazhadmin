@extends('layouts.main')
@section('title', ' Order List')
@section('content')

@php
    if(Auth::user()->hasPermission('order-management')){
      $permission = 'order-management';
    }else if(Auth::user()->isSuperAdmin()){
      $permission = 'super-admin';
    }
    else if(Auth::user()->hasPermission('inventory-management')){
      $permission = 'inventory-management';
    }
@endphp
<order-lists permission-user={{$permission}} />
@endsection

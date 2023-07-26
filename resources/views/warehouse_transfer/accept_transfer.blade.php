<!-- accept inventory -->
@extends('layouts.main')
@section('title', ' Accept Transfer')
@section('content')

@php
    $auth = [ 'isAdmin'=> Auth::user()->isSuperAdmin(),'inventory_id'=>Auth::user()->inventory_id ];
@endphp
    <inventory-transfer-accept :auth-user={{ json_encode($auth) }} />

    <!-- Modal -->


@endsection

@extends('layouts.main')
@section('title', ' Size Chart')
@section('content')

<div class="inner-main-container">
    <div>
        <p class="page-tittle">Size Chart Management</p>
    </div>

    <div class=" relative flex justify-between">
        @include('layouts.search_box')
        <div>
            <a href="/size_chart/create" class="a-clear create-btn" type="button" style="margin-top: 8px">
                Add New
            </a>
        </div>
    </div>

    <size-guide-lists />
</div>

@endsection

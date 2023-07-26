@extends('layouts.main')
@section('title', ' Create Size Chart')
@section('content')
<!-- <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script> -->

@php
    if(!isset($size_guide)){
        $size_guide = [
            "id"=> null,
            "name"=> ""
        ];
    }
@endphp

<size-guide-create :size_guide="{{json_encode($size_guide)}}" />

@endsection

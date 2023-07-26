@extends('layouts.main')
@section('title', ' Customer Help')
@section('content')

@auth
    <chats-view-initialize admin="{{json_encode(Auth::user())}}"/>
@endauth

@endsection

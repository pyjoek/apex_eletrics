@extends('layouts.app')

@section('header')
User Profile
@endsection

@section('content')
<div>
    <h1>Name: </h1>{{$user->name}}
    <h1>Email: </h1>{{$user->email}}
    <h1>Role: </h1>{{$user->role}}
</div>
@endsection
@extends('layouts.app')

@section('header')
User Profile
@endsection

@section('content')
<div>
    Name: <h1>{{$user->name}}</h1>
    Email: <h1>{{$user->email}}</h1>
    Role: <h1>{{$user->role}}</h1>
</div>
@endsection
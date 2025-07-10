@extends('layouts.app')

@section('content')
<h2>Customer List</h2>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr><th>Name</th><th>Email</th></tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
        <tr><td>{{ $project->name }}</td><td>{{ $project->email }}</td></tr>
        @endforeach
    </tbody>
</table>

@endsection
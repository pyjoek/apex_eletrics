@extends('layouts.app')

@section('header')
Projects
@endsection

@section('content')

<form action="{{ route('projects.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">Import Excel</button>
</form>

<a href="{{ route('projects.export.excel') }}">Export to Excel</a>
<a href="{{ route('projects.export.pdf') }}">Export to PDF</a>

<table>
    <tr>
        <th>Name</th>
    </tr>
    @foreach($projects as $project)
        <tr><td>{{ $project->project }}</td>
    @endforeach
</table>

@endsection
@extends('layouts.app')

@section('header')
Invoice Page
@endsection

@section('content')
<style>
    .form-section {
        background-color: #fff;
        padding: 20px;
        margin-bottom: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .form-section select {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
        width: 100%;
        max-width: 400px;
    }

    .form-section button {
        margin-top: 15px;
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    .form-section button:hover {
        background-color: #0b5ed7;
    }
</style>

<center>
    <div class="form-section">
        <form id="projectForm">
            <label for="project" class="fw-bold">Choose Project:</label>
            <select id="project" name="project" required>
                <option value="">-- Select Project --</option>
                @foreach ($projects as $project)
                    <option value="{{ route('work', $project->id) }}">
                        {{ $project->project }}
                    </option>
                @endforeach
            </select>
            <br>
            <button type="submit">Go</button>
        </form>
    </div>
</center>

<script>
    document.getElementById('projectForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let url = document.getElementById('project').value;
        if (url) {
            window.location.href = url;
        }
    });
</script>
@endsection

@extends('layouts.app')

@section('header')
Projects
@endsection

@section('content')

<style>


    .form-section, .table-section {
        background-color: #fff;
        padding: 20px;
        margin-bottom: 30px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .form-section input[type="file"] {
        padding: 5px;
        margin-bottom: 10px;
    }

    .form-section button {
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

    .export-links a {
        margin-right: 10px;
        text-decoration: none;
        background-color: #198754;
        color: white;
        padding: 6px 12px;
        border-radius: 5px;
    }

    .export-links a:last-child {
        background-color: #dc3545;
    }

    .export-links a:hover {
        opacity: 0.9;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    table, th, td {
        border: 1px solid #dee2e6;
    }

    th {
        background-color: #343a40;
        color: white;
        padding: 10px;
        text-align: left;
    }

    td {
        padding: 10px;
        background-color: #ffffff;
    }

    tr:nth-child(even) td {
        background-color: #f2f2f2;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const project = document.querySelector('.project');
        const customer = document.querySelector('.customer');
        const supplier = document.querySelector('.supplier');
        const button = document.getElementById('toggle-btn');
        project.style.display = 'block';
        customer.style.display = 'none';
        supplier.style.display = 'none';
    })

    function project() {
        const project = document.querySelector('.project');
        const customer = document.querySelector('.customer');
        const supplier = document.querySelector('.supplier');

        project.style.display = 'block';
        customer.style.display = 'none';
        supplier.style.display = 'none';
    }

    function customer() {
        const project = document.querySelector('.project');
        const customer = document.querySelector('.customer');
        const supplier = document.querySelector('.supplier');

        project.style.display = 'none';
        customer.style.display = 'block';
        supplier.style.display = 'none';
    }

    function supplier() {
        const project = document.querySelector('.project');
        const customer = document.querySelector('.customer');
        const supplier = document.querySelector('.supplier');

        project.style.display = 'none';
        customer.style.display = 'none';
        supplier.style.display = 'block';
    }
</script>

<center>
    <div class="form-selectin mb-2">
        <button id="toggle-btn" class="btn btn-primary" onclick="project()">Add New Project</button>
        <button id="toggle-btn" class="btn btn-primary" onclick="customer()">Add New Customer</button>
        <button id="toggle-btn" class="btn btn-primary" onclick="supplier()">Add New Supplier</button>
    </div>
    
    <div class="project mt-5">
        <div class="form-section">
            <form action="{{ route('new.project') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="project" placeholder="New Project">
                <button type="submit">Add</button>
            </form>
        </div>
    
        <div>
            <!-- display table of projects -->
            <div class="table-section" style="width: 70%">
                <table>
                    <thead>
                        <tr>
                            <th colspan="3"><center>Project Name</center></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->project }}</td>
                            <td><a href="/projects/{{ $project->id }}"><center><button class="btn btn-secondary">Invoice</button></center></a></td>
                            <td><a href="/expense/{{ $project->id }}"><center><button class="btn btn-secondary">Expense</button></center></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="customer mt-5">
        <h1>Add Customer</h1>

        <center>
            <div class="form-section row">
                <form action="{{ route('new.customer') }}" method="POST" enctype="multipart/form-data" class="col-6 mx-auto">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Customer's Name">
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="address" class="form-control" placeholder="Address">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="contact" class="form-control" placeholder="Contact">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="tin" class="form-control" placeholder="TIN">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="vrn" class="form-control" placeholder="VRN">
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </center>
    </div>

    <div class="supplier mt-5">
        <h1>Add Supplier</h1>

        <center>
            <div class="form-section row">
                <form action="{{ route('new.supplier') }}" method="POST" enctype="multipart/form-data" class="col-6 mx-auto">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Customer's Name">
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="address" class="form-control" placeholder="Address">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="contact" class="form-control" placeholder="Contact">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="tin" class="form-control" placeholder="TIN">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="vrn" class="form-control" placeholder="VRN">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="category" class="form-control" placeholder="Category">
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </center>
    </div>

</center>


@endsection
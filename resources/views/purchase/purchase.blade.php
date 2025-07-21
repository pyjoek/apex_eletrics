@extends('layouts.app')

@section('header')
Order Item
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

<center>
    <div class="form-section">
        <form action="{{ route('invoices.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" required>
            <button type="submit">Import Excel</button>
        </form>
    </div>
    
    <div class="invoice-form mt-5">

    <center>
        <div class="form-section row">
            <form action="{{ route('new.purchase') }}" method="POST" enctype="multipart/form-data" class="col-6 mx-auto">
                @csrf

                <div class="mb-3">
                    <select name="supplier" class="form-select">
                        @foreach ($supplier as $proj)
                            <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <input type="text" name="item" class="form-control" placeholder="Item Name">
                </div>

                <div class="mb-3">
                    <input type="text" name="unit" class="form-control" placeholder="Unit">
                </div>

                <div class="mb-3">
                    <input type="number" name="quantity" class="form-control" placeholder="Quantity">
                </div>

                <div class="mb-3">
                    <input type="number" name="price" class="form-control" placeholder="Price">
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Insert</button>
                </div>
            </form>
        </div>
    </center>
</div>

    
</center>

@endsection
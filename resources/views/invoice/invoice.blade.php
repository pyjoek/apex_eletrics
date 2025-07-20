@extends('layouts.app')

@section('header')
Add Item to Project
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
    <h1>Add Invoice Item</h1>

    <center>
        <div class="form-section row">
            <form action="{{ route('new.invoice') }}" method="POST" enctype="multipart/form-data" class="col-6 mx-auto">
                @csrf

                <div class="mb-3">
                    <select name="project" class="form-select">
                        @foreach ($project as $proj)
                            <option value="{{ $proj->project }}">{{ $proj->project }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <select name="customer" class="form-select">
                        @foreach ($customer as $cust)
                            <option value="{{ $cust->name }}">{{ $cust->name }}</option>
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
                    <button type="submit" class="btn btn-success">Insert</button>
                </div>
            </form>
        </div>
    </center>
</div>

    
    <!-- <div class="table-section">
        <table>
            <thead>
                <tr>
                    <th>Project Name</th>
                    <th>Customer Name</th>
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->project->project }}</td>
                    <td>{{ $invoice->customer->name }}</td>
                    <td>{{ $invoice->item }}</td>
                    <td>{{ $invoice->unit }}</td>
                    <td>{{ $invoice->quantity }}</td>
                    <td>{{ $invoice->price }}</td>
                    <td>{{ $invoice->quantity * $invoice->price }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> -->
</center>

@endsection
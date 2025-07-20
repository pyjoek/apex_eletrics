@extends('layouts.app')

@section('header')
{{ $expense->first()->project->project }} Expenses Page
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
    }Invoice

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

    <div class="table-section">
         <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = $invoices->sum(fn($inv) => $inv->price * $inv->quantity);
                    $expen = $expense->sum(fn($inv) => $inv->price * $inv->quantity);
                @endphp
                
                @foreach($expense as $invoice)
                <tr>
                    <td>{{ $invoice->item }}</td>
                    <td>{{ $invoice->unit }}</td>
                    <td>{{ $invoice->quantity }}</td>
                    <td>{{ number_format($invoice->price, 0) }}</td>
                    <td>{{ number_format($invoice->quantity * $invoice->price, 0) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3"></td>
                    <td>Invoice</td>
                    <td>{{number_format($total, 0)}}</td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                    <td>Remaining</td>
                    <td>{{number_format($total - $expen)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</center>

@endsection
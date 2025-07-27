@extends('layouts.app')

@section('header')
Purchase Order
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
        <form id="export-form" method="GET" target="_blank">
            {{-- Export Links --}}
            <div class="export-links" style="margin-top: 15px;">
                <button type="submit" class="export-btn" formaction="{{ route('purchase.export.excel', $id) }}">
                    Export to Excel
                </button>
                <button type="submit" class="export-btn" formaction="{{ route('purchase.export.pdf', $id) }}">
                    Export Purchase Order to PDF
                </button>
            </div>
    
            {{-- Shared Invoice Data --}}
            <div style="margin-top: 20px; row">
                <p>
                    <input class="col-5" type="text" name="title" placeholder="The Purchase Order title">
                </p>
                <textarea class="col-9" name="terms" placeholder="- Payment in 30 days&#10;- No refunds&#10;- 1 year warranty"></textarea>
    
            </div>
        </form>
    </div>
    
    <div class="table-section">
        <table>
            <thead>
                <tr>
                    <th>Supplier Name</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = $supp->sum(fn($inv) => $inv->price * $inv->quantity);
                @endphp

                @foreach($supp as $supplier)
                <tr>
                    <td>{{$supplier->supplier->name}}</td>
                    <td>{{$supplier->item}}</td>
                    <td>{{$supplier->quantity}}</td>
                    <td>{{$supplier->unit}}</td>
                    <td>{{number_format($supplier->price, 0)}}</td>
                    <td>{{number_format($supplier-> quantity * $supplier->price, 0)}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4"></td>
                    <td >Gross Total</td>
                    <td>{{number_format($total, 0)}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</center>

@endsection
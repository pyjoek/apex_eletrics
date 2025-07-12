@extends('layouts.app')

@section('header')
{{ $projects->project }}
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

<div class="form-section">

    <div class="export-links" style="margin-top: 15px;">
        <a href="{{ route('invoices.export.excel', $projects->id) }}">Export to Excel</a>
        <a href="{{ route('invoices.export.pdf', $projects->id) }}">Export Invoice to PDF</a>
        <a href="{{ route('profoma.export.pdf', $projects->id) }}">Export Profoma to PDF</a>
        <a href="{{ route('delivery.export.pdf', $projects->id) }}">Export delivery to PDF</a>
    </div>
</div>

<div class="table-section">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Quantity&nbsp;/&nbsp;Unit</th>
                <th>Price</th>
                <th>Amount</th>
            </tr>
        </thead>

        @php
            $total = $invoices->sum(fn($inv) => $inv->price * $inv->quantity);
        @endphp

        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->item }}</td>
                    <td>{{ $invoice->quantity }} {{ $invoice->unit }}</td>
                    <td>{{ $invoice->price }}</td>
                    <td>{{ number_format($invoice->price * $invoice->quantity, 0) }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr class="fw-bold">
                <td colspan="3" class="text-end">Total</td>
                <td>{{ number_format($total, 0) }}</td>
            </tr>
        </tfoot>
    </table>
</div>

@endsection
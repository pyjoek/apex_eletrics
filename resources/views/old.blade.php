@extends('layouts.app')
<link rel="stylesheet" href="{{asset('css/work.css')}}">
@section('header')
{{ $projects->project }} Invoice of Date: {{$hist->created_at->format('Y-m-d')}}
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
                <button type="submit" class="export-btn" formaction="{{ route('invoices.export.excel', $projects->id) }}">
                    Export to Excel
                </button>
                <button type="submit" class="export-btn" formaction="{{ route('invoices.export.pdf', $projects->id) }}">
                    Export Invoice to PDF
                </button>
                <button type="submit" class="export-btn" formaction="{{ route('profoma.export.pdf', $projects->id) }}">
                    Export Proforma to PDF
                </button>
                <button type="submit" class="export-btn" formaction="{{ route('delivery.export.pdf', $projects->id) }}">
                    Export Delivery to PDF
                </button>
            </div>
    
            {{-- Shared Invoice Data --}}
            <div style="margin-top: 20px; row">
                <p>
                    <input class="col-5" type="text" name="title" value="{{$hist->title}}">
                    <input class="col-2" type="number" name="tax" value="{{$hist->tax}}">
                    <input class="col-2" type="number" name="discount" value="{{$hist->discount}}">
                </p>
                <textarea class="col-9" name="terms" placeholder="- Payment in 30 days&#10;- No refunds&#10;- 1 year warranty">{{$hist->terms}}</textarea>
    
            </div>
        </form>
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
    
</center>

@endsection
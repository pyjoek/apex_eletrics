@extends('layouts.app')
<link rel="stylesheet" href="{{asset('css/work.css')}}">
@section('header')
{{ $projects->project }} Invoice Page
@endsection

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

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
                    <input class="col-5" type="text" name="title" placeholder="The Invoice title" required>
                    <input type="hidden" name="id" value="{{$id}}">
                    <input class="col-2" type="number" name="tax" placeholder="VAT tax" required>
                    <input class="col-2" type="number" name="discount" placeholder="Discount Percent">
                </p>
                <textarea class="col-9" name="terms" placeholder="- Payment in 30 days&#10;- No refunds&#10;- 1 year warranty" required></textarea>
    
            </div>
        </form>
    </div>
    
    <div class="table-section">
        <form action="{{ route('new.invoice') }}" method="POST" enctype="multipart/form-data" class="col-6 mx-auto">
            @csrf
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity&nbsp;/&nbsp;Unit</th>
                        <th>Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>

                <tbody id="invoice-items-body">
                    @php
                        $total = $invoices->sum(fn($inv) => $inv->price * $inv->quantity);
                    @endphp
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>
                                <input type="text" name="item[]" class="form-control" value="{{ $invoice->item }}" readonly>
                            </td>
                            <td>
                                <input type="number" name="quantity[]" class="form-control quantity-input" value="{{ $invoice->quantity }}" readonly style="width: 70px; display: inline-block;">
                                <input type="text" name="unit[]" class="form-control" value="{{ $invoice->unit }}" readonly style="width: 70px; display: inline-block;">
                            </td>
                            <td>
                                <input type="number" name="price[]" class="form-control price-input" value="{{ $invoice->price }}" readonly>
                            </td>
                            <td class="amount-cell">{{ number_format($invoice->price * $invoice->quantity, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right;">
                            <button type="button" id="add-row-btn" class="btn btn-primary">Add Item Row</button>
                        </td>
                    </tr>
                    <tr class="fw-bold">
                        <td colspan="3" class="text-end">Total</td>
                        <td id="total-cell">{{ number_format($total, 0) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right;">
                            <button type="submit" class="btn btn-success">Save Items</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>
    <script>
        function recalculateTotal() {
            let total = 0;
            document.querySelectorAll('#invoice-items-body tr').forEach(function(row) {
                const qty = parseFloat(row.querySelector('.quantity-input')?.value) || 0;
                const price = parseFloat(row.querySelector('.price-input')?.value) || 0;
                const amount = qty * price;
                row.querySelector('.amount-cell').textContent = amount ? amount.toLocaleString() : '';
                total += amount;
            });
            document.getElementById('total-cell').textContent = total.toLocaleString();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const addRowBtn = document.getElementById('add-row-btn');
            const tbody = document.getElementById('invoice-items-body');

            addRowBtn.addEventListener('click', function() {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td><input type="text" name="item[]" class="form-control" placeholder="Item Name" required></td>
                    <td>
                        <input type="number" name="quantity[]" class="form-control quantity-input" placeholder="Quantity" style="width: 70px; display: inline-block;" required>
                        <input type="text" name="unit[]" class="form-control" placeholder="Unit" style="width: 70px; display: inline-block;" required>
                    </td>
                    <td><input type="number" name="price[]" class="form-control price-input" placeholder="Price" required></td>
                    <td class="amount-cell">0</td>
                `;
                tbody.appendChild(tr);
            });

            // Listen for input changes to recalculate amounts and total
            document.getElementById('items-form').addEventListener('input', function(e) {
                if (e.target.classList.contains('quantity-input') || e.target.classList.contains('price-input')) {
                    recalculateTotal();
                }
            });

            recalculateTotal();
        });
    </script>
    
    <div class="table-section">
        <h1>Invoice History</h1>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Invoice name</th>
                    <th>Date</th>
                    <th  colspan="2" class="text-center">Actions</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($hist as $invoice)
                    <tr>
                        <td>{{$invoice->title}}</td>
                        <td>{{$invoice->created_at->format('Y-m-d')}}</td>
                        <td><a href="/old/{{$invoice->id}}"><center><button class="btn btn-secondary">Open</button></center></a></td>
                        <td><a href="/old/delete/{{$invoice->id}}"><center><button class="btn btn-danger">Delete</button></center></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</center>

@endsection
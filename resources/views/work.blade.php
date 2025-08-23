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
        <form id="export-form" method="POST" enctype="multipart/form-data" target="_blank">
            @csrf
            <div class="row" style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 15px;">
                <div style="display: flex; justify-content: center; align-items: center; width: 100%;">
                    <div style="margin-right: 15px;">
                        <label for="project-select" style="margin-right: 5px;">Project:</label>
                        <select id="project-select" name="project" class="form-select" style="display: inline-block; width: auto;">
                            @foreach($allprojects as $project)
                                <option value="{{ $project->id }}" {{ $project->id == $id ? 'selected' : '' }}>
                                    {{ $project->project }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-right: 15px;">
                        <label for="customer-select" style="margin-right: 5px;">Customer:</label>
                        <select id="customer-select" name="customer" class="form-select" style="display: inline-block; width: auto;">
                            @foreach($allcustomers as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                   
                    <div class="export-links" style="position: relative;">
                        <div style="display: flex; justify-content: flex-end; position: relative;">
                            <button type="button" id="export-main-btn" class="export-btn">
                                Export ▼
                            </button>
                            <div id="export-dropdown" style="display: none; position: absolute; right: 0; top: 40px; background: #fff; border: 1px solid #ccc; border-radius: 5px; min-width: 200px; z-index: 1000; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                                <button type="submit" class="export-btn" style="width: 100%; text-align: left; background: none; color: #212529; border: none; padding: 10px;" formmethod="GET" formaction="{{ route('invoices.export.excel', $projects->id) }}">
                                    Export to Excel
                                </button>
                                <button type="submit" class="export-btn" style="width: 100%; text-align: left; background: none; color: #212529; border: none; padding: 10px;" formmethod="GET" formaction="{{ route('invoices.export.pdf', $projects->id) }}">
                                    Export Invoice to PDF
                                </button>
                                <button type="submit" class="export-btn" style="width: 100%; text-align: left; background: none; color: #212529; border: none; padding: 10px;" formmethod="GET" formaction="{{ route('profoma.export.pdf', $projects->id) }}">
                                    Export Proforma to PDF
                                </button>
                                <button type="submit" class="export-btn" style="width: 100%; text-align: left; background: none; color: #dc3545; border: none; padding: 10px;" formmethod="GET" formaction="{{ route('delivery.export.pdf', $projects->id) }}">
                                    Export Delivery to PDF
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const mainBtn = document.getElementById('export-main-btn');
                    const dropdown = document.getElementById('export-dropdown');
                    mainBtn.addEventListener('click', function() {
                        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                    });
                    document.addEventListener('click', function(e) {
                        if (!mainBtn.contains(e.target) && !dropdown.contains(e.target)) {
                            dropdown.style.display = 'none';
                        }
                    });
                });
            </script>
    
            <div class="table-section">
                @csrf
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity&nbsp;/&nbsp;Unit</th>
                            <th> Unit Price</th>
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
                                <button type="submit" class="export-btn" formaction="{{ route('new.invoice') }}">
                                    Save
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                
                {{-- Shared Invoice Data --}}
                <div style="margin-top: 20px; row">
                    <p>
                        <input class="col-5" type="text" name="title" placeholder="The Invoice title" >
                        <input class="col-2" type="number" name="tax" placeholder="VAT tax" >
                        <input class="col-2" type="number" name="discount" placeholder="Discount Percent">
                    </p>
                    <textarea class="col-9" name="terms" placeholder="- Payment in 30 days&#10;- No refunds&#10;- 1 year warranty" ></textarea>
                </div>
            </div>
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

                // Attach input event listeners for real-time calculation
                tr.querySelectorAll('.quantity-input, .price-input').forEach(function(input) {
                    input.addEventListener('input', recalculateTotal);
                });
            });

            // Initial calculation
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
                    <th colspan="2" class="text-center">Actions</th>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
     <link href="{{ public_path('css/bootstrap-grid.min.css') }}" rel="stylesheet" media="all">
    <title>Tax Invoice</title>
    <style>
    /* ---- Bootstrap‑like grid for PDF ---- */
    /* .row { display:flex; flex-wrap:wrap; } */
    .col-1 { flex:0 0 8.333%; max-width:8.333%; }
    .col-2 { flex:0 0 16.666%; max-width:16.666%; }
    .col-3 { flex:0 0 25%; max-width:25%; }
    .col-4 { flex:0 0 33.333%; max-width:33.333%; }
    .col-5 { flex:0 0 41.666%; max-width:41.666%; }
    .col-6 { flex:0 0 50%; max-width:50%; }
    /* add other .col-* as needed */
    .align-items-center { align-items:center; }
    .text-center { text-align:center; }
    </style>

    <style>
        /* --- Minimal grid for PDF (only what we need) --- */
        /* .row { display: flex; flex-wrap: wrap;} */
        .rowd { display: flex; flex-direction: row}
        .col-3 { flex: 0 0 25%; max-width: 25%; }
        .col-4 { flex: 0 0 33.3333%; max-width: 33.3333%; }
        .col-5 { flex: 0 0 41.6667%; max-width: 41.6667%; }
        .align-items-center { align-items: center; }
        .text-center { text-align: center; }
    </style>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            padding: 30px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #f8f9fa;
        }

        th, td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #343a40;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
    <style>
    .terms-text {
        float: left;
        width: 70%;        /* leave room for the stamp */
    }
    .terms-image {
        float: left;
        width: 100px;      /* stamp width */
    }
    .terms-image img {
        max-width: 100%;   /* fit the box */
        -dompdf-transform: rotate(-45deg);  /* dompdf‑specific */
        transform: rotate(-45deg);          /* browser preview */
        display: block;
    }
    /* clear the floats so content below isn’t affected */
    .clearfix::after {
        margin-top: 2rem;
        content: '';
        display: table;
        clear: both;
    }
</style>
</head>
<body>

<table style="width: 100%; border-collapse: collapse; border: 1px solid white;">
    <tr style="border: 1px solid white;">
        <td style="border: 1px solid white; width: 100px;">
            <img src="{{ public_path('img/logo.jpeg') }}" style="width: 100px;" alt="Company Logo">
        </td>
        <td style="border: 1px solid white; width: 200px; text-align: right; padding-left: 10px;">
            <h4 style="margin: 0;">TIN: 151-621-767</h4>
            <h4 style="margin: 0;">VRN: 400-48777-N</h4>
        </td>
        <td style="border: 1px solid white; text-align: right; width: 100%; padding-left: 0;">
            Web: www.apexelectronics.co.tz<br>
            Email: info@apexelectronics.co.tz<br>
            Phone: +255 767 750 937<br>
            MAKAO MAPYA ROAD NEAR CCM<br>
            LEVOLOSI<br>
            P.O.Box 8102 ARUSHA<br>
            TANZANIA
        </td>
    </tr>
</table>
 
<center>
    <h3>TAX INVOICE</h3>
    <h2>{{$data['title']}}</h2>
</center>

<table style="width: 100%; border-collapse: collapse; border: 1px solid white;">
    <tr style="border: 1px solid white;">
        <!-- Make this column 60% -->
        <td style="border: 1px solid white; width: 70%; vertical-align: top;">
            <h3>BILL TO:</h3>
            Name: {{$invoices->first()->customer->name}}<br>
            Email: {{$invoices->first()->customer->email}}<br>
            Address: {{$invoices->first()->customer->address}}<br>
            Contact: {{$invoices->first()->customer->contact}}<br>
            TIN No.: {{$invoices->first()->customer->tin}}<br>
            VRN No.: {{$invoices->first()->customer->vrn}}<br>
        </td>
        <!-- Make this column 40% -->
        <td style="border: 1px solid white; text-align: right; width: 30%; vertical-align: top;">
            {{ date('Y/M/d') }}
            <p>INV.NO: {{$invoices->first()->id}}</p>   
        </td>
    </tr>
</table>

  <div class="table-section">
    <table>
        <thead>
            <tr>
                <th>S/N</th>
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
                $tax = $total * ($data['tax'] / 100);
                $discount = $total * ($data['discount'] / 100);
                $newTotal = $total + $tax - $discount;

                $stampBase64 = 'data:image/png;base64,' . base64_encode(
                    file_get_contents(public_path('img/stamp.png'))
                );

            @endphp
            @foreach($invoices as $index => $invoice)
            <tr>
                <td>{{ $index + 1}}</td>
                <td>{{ $invoice->item }}</td>
                <td>{{ $invoice->unit }}</td>
                <td>{{ $invoice->quantity }}</td>
                <td>{{ number_format($invoice->price, 0)}}</td>
                <td>{{ number_format($invoice->quantity * $invoice->price, 0) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5">Total</td>
                <td>{{number_format($total, 0)}}</td>
            </tr>
            <tr>
                <td colspan="5">VAT TAX {{$data['tax']}}%</td>
                <td>{{number_format($tax, 0)}}</td>
            </tr>
            <tr>
                <td colspan="5">Discount {{$data['discount']}}%</td>
                <td>{{number_format($discount, 0)}}</td>
            </tr>
            <tr>
                <td colspan="5">Gross Total</td>
                <td>{{number_format($newTotal, 0)}}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="clearfix">
    <div class="terms-text">
        <h3>Terms and Conditions</h3>
        <ul>
            @foreach ($data['terms'] as $term)
                <li>{{ $term }}</li>
            @endforeach 
        </ul>
    </div>

    <div class="terms-image">
        <img src="{{ public_path('img/stamp.png') }}" alt="Company stamp">
    </div>
</div>

<div>
    BANK DETAILS<br>
    ACCOUNT NAME: APEX ELECTRICS LIMITED<br>
    ACCOUNT NUMBER: 40810136201<br>
    BANK NAME: NMB<br>
    BRANCH: CLOCK TOWER<br>
    SWIFT: NMIIBTZTZ<br>
    BRANCH CODE: 408
</div>

</body>
</html>

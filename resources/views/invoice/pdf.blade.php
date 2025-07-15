<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Tax Invoice</title>
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
    <div class="row align-items-center">
        <div class="col-3">
            <h1>logo</h1>
        </div>

        <div class="col-5">
            <h4>TIN: {{$invoices->first()->customer->tin}}</h4>
            <h4>VRN: {{$invoices->first()->customer->vrn}}</h4>
        </div>

        <div class="col-4">
            Web: www.apexelectronics.co.tz<br>
            Email: info@apexelectronics.co.tz<br>
            Phone: +255 767 750 937<br>
            MAKAO MAPYA ROAD NEAR CCM<br>
            LEVOLOSI<br>
            P.O.Box 8102 ARUSHA<br>
            TANZAINIA
        </div>
    </div>

<center>
    <h1>TAX INVOICE</h1>
    <h2>{{$data['title']}}</h2>
</center>

<div class="row">
    <div class="col-9">
        <p><h1>BILL TO:</h1></p>

    </div>

    <div class="col-3">
        <input type="date" name="date" id="">
        <p>INV.NO: {{$invoices->first()->id}}</p>
    </div>
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
                $tax = $total * ($data['tax'] / 100);
                $discount = $total * ($data['discount'] / 100);
                $newTotal = $total + $tax - $discount;

                $stampBase64 = 'data:image/png;base64,' . base64_encode(
                    file_get_contents(public_path('img/stamp.png'))
                );

            @endphp
            @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->item }}</td>
                <td>{{ $invoice->unit }}</td>
                <td>{{ $invoice->quantity }}</td>
                <td>{{ number_format($invoice->price, 0)}}</td>
                <td>{{ number_format($invoice->quantity * $invoice->price, 0) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="4">Total</td>
                <td>{{number_format($total, 0)}}</td>
            </tr>
            <tr>
                <td colspan="4">VAT TAX {{$data['tax']}}%</td>
                <td>{{number_format($tax, 0)}}</td>
            </tr>
            <tr>
                <td colspan="4">Discount {{$data['discount']}}%</td>
                <td>{{number_format($discount, 0)}}</td>
            </tr>
            <tr>
                <td colspan="4">Gross Total</td>
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

</body>
</html>

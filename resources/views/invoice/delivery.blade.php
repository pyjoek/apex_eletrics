<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Note</title>
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


<h1>{{$data['title']}}</h1>

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

    <!-- <div class="footer">
        &copy; {{ date('Y') }} JR Institute — Project Report
    </div> -->
</body>
</html>

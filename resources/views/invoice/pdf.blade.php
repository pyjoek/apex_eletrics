<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>invoice</title>
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
</head>
<body>

<h1>{{$data['title']}}</h1>

  <div class="table-section">
    <table>
        <thead>
            <tr>
                <th>Project Name</th>
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
                <td>{{ $invoice->project->project }}</td>
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

<div>
    <h1>Terms and Conditions</h1>
    <p>
        <li>{{$data['terms']}}</li>
    </p>
</div>

    <!-- <div class="footer">
        &copy; {{ date('Y') }} JR Institute — Project Report
    </div> -->
</body>
</html>

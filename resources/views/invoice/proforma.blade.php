<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profoma</title>
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

<h1>Profoma</h1>

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
            @endphp
            @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->project->project }}</td>
                <td>{{ $invoice->item }}</td>
                <td>{{ $invoice->unit }}</td>
                <td>{{ $invoice->quantity }}</td>
                <td>{{ $invoice->price }}</td>
                <td>{{ $invoice->quantity * $invoice->price }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5">Total</td>
                <td>{{$total}}</td>
            </tr>
        </tbody>
    </table>
</div>

    <!-- <div class="footer">
        &copy; {{ date('Y') }} JR Institute — Project Report
    </div> -->
</body>
</html>

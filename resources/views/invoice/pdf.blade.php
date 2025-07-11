<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Report</title>
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

    <h2>All Projects</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Project Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $i => $project)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $project->project }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- <div class="footer">
        &copy; {{ date('Y') }} JR Institute — Project Report
    </div> -->
</body>
</html>

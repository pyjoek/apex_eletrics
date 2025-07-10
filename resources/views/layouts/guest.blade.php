<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<body class="bg-light text-dark">
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center pt-5 bg-light">

        <div class="w-100 mt-4 p-4 bg-white shadow rounded" style="max-width: 400px;">
            {{ $slot }}
        </div>
    </div>
</body>

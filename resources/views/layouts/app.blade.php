<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Top Header -->
    <header class="bg-dark text-white text-center py-3">
        <h1>@yield('header')</h1>
    </header>

    <!-- Horizontal Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Apex Project Management System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                 
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Section -->
    <div class="container-fluid">
        <div class="row">

            <!-- Left Side Nav Column -->
            <aside class="col-md-3 col-lg-1 bg-light border-end p-4 min-vh-100">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="/projects">Projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="/invoice">Invoice</a></li>
                    <li class="nav-item"><a class="nav-link" href="">Expense</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Other</a></li>
                    <form action="{{ route('logout') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="btn btn-warning mt-4">Log out</button>
                    </form>
                </ul>
            </aside>

            <!-- Right Side Content Column -->
            <main class="col-md-9 col-lg-10 p-5">
                @yield('content')
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

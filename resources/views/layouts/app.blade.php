<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Apex Management System') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-size: 0.9rem;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        /* Sidebar styling */
        .sidebar {
            min-height: 100vh;
            background-color: #fff;
            border-right: 1px solid #ddd;
        }
        .sidebar .brand {
            font-weight: bold;
            font-size: 1.2rem;
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: center;
            background: #0d6efd;
            color: white;
        }
        .sidebar .nav-link {
            color: #333;
            padding: 10px 15px;
            margin: 4px 8px;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
        }
        .sidebar .nav-link:hover {
            background-color: #0d6efd;
            color: #fff !important;
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff !important;
            font-weight: 600;
        }
        /* Main content */
        main {
            background: #fdfdfd;
            min-height: 100vh;
        }
        .page-header {
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
            <div class="brand">
                Apex Management
            </div>
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}" 
                       href="{{ route('profile.show') }}">
                        Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('projects*') ? 'active' : '' }}" 
                       href="/projects">
                        Projects
                    </a>
                </li>
               <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('show.purchase') ? 'active' : '' }}" 
                    href="{{ route('show.purchase') }}">
                        Purchase Order
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('purchase') ? 'active' : '' }}" 
                    href="/purchase">
                        Order Item
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('invoice*') ? 'active' : '' }}" 
                       href="/invoice">
                        Add Items
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('expense*') ? 'active' : '' }}" 
                       href="/expense">
                        Add Expense
                    </a>
                </li>
            </ul>

            <div class="p-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">Log out</button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="page-header">
                <h2>@yield('header')</h2>
            </div>
            @yield('content')
        </main>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

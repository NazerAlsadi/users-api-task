<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'MyApp') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (optional) -->
    <style>
        body {
            background: #f5f7fa;
        }
        .navbar-brand {
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .card {
            border-radius: 10px;
        }
    </style>

</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'MyApp') }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">

                <ul class="navbar-nav ms-auto">

                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>

                        @if(auth()->user()->hasRole('admin'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users') }}">Admin Panel</a>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userMenu" data-bs-toggle="dropdown">
                                {{ auth()->user()->name }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                    @else

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>

                    @endauth

                </ul>

            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

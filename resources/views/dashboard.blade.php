<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark p-3">
    <span class="navbar-brand">Dashboard</span>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-danger btn-sm">Logout</button>
    </form>
</nav>

<div class="container mt-4">

    <h3>Welcome, {{ auth()->user()->name }}</h3>
    <p>Your email: {{ auth()->user()->email }}</p>

    <p><strong>Your Roles:</strong>
        @foreach (auth()->user()->roles as $role)
            <span class="badge bg-primary">{{ $role->name }}</span>
        @endforeach
    </p>

    @if(auth()->user()->roles->contains('name','admin'))
        <a href="{{ route('admin.users') }}" class="btn btn-primary mt-3">Go to Admin Panel</a>
    @endif

</div>

</body>
</html>

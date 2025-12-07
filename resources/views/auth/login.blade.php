<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width: 500px;">
    <div class="card shadow">
        <div class="card-body">

            <h3 class="text-center mb-4">Login</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $e)
                        <div>{{ $e }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <button class="btn btn-primary w-100">Login</button>
            </form>

            <p class="mt-3 text-center">
                Don't have an account?
                <a href="{{ route('register') }}">Register</a>
            </p>

        </div>
    </div>
</div>

</body>
</html>
